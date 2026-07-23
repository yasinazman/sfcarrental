<?php
namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\I18n\FrozenDate;

class AdminsSalesController extends AppController
{
    public function index()
    {
        $paymentsTable = $this->fetchTable('Payments');
        
        $search = $this->request->getQuery('search');
        $statusFilter = $this->request->getQuery('status');
        $monthFilter = $this->request->getQuery('month');

        $totalRevenue = $paymentsTable->find()
            ->where(['payment_status NOT IN' => ['Pending', 'Failed', 'Cancelled']])
            ->all() 
            ->sumOf('total_payment');

        $now = FrozenTime::now();
        $startOfMonth = $now->startOfMonth()->format('Y-m-d 00:00:00');
        
        $monthlyPayments = $paymentsTable->find()
            ->where([
                'payment_status NOT IN' => ['Pending', 'Failed', 'Cancelled'],
                'created >=' => $startOfMonth
            ])
            ->all();
            
        $monthlyRevenue = $monthlyPayments->sumOf('total_payment');

        $pendingAmount = $paymentsTable->find()
            ->where(['payment_status' => 'Pending'])
            ->all()
            ->sumOf('total_payment');

        $startOfWeek = $now->subDays(6)->startOfDay();
        $weeklyPayments = $paymentsTable->find()
            ->where(['payment_status NOT IN' => ['Pending', 'Failed', 'Cancelled'], 'created >=' => $startOfWeek])
            ->all();
            
        $weeklyTotals = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = FrozenTime::now()->subDays($i)->format('d M');
            $weeklyTotals[$date] = 0;
        }
        foreach ($weeklyPayments as $p) {
            $dateString = $p->created->format('d M');
            if (isset($weeklyTotals[$dateString])) $weeklyTotals[$dateString] += $p->total_payment;
        }

        $monthlyTotals = [];
        $daysInMonth = (int)FrozenTime::now()->format('t');
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = FrozenTime::now()->setDate($now->year, $now->month, $i)->format('d M');
            $monthlyTotals[$date] = 0;
        }
        foreach ($monthlyPayments as $p) {
            $dateString = $p->created->format('d M');
            if (isset($monthlyTotals[$dateString])) $monthlyTotals[$dateString] += $p->total_payment;
        }

        $startOfYear = $now->startOfYear()->format('Y-m-d 00:00:00');
        $yearlyPayments = $paymentsTable->find()
            ->where(['payment_status NOT IN' => ['Pending', 'Failed', 'Cancelled'], 'created >=' => $startOfYear])
            ->all();
            
        $yearlyTotals = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthStr = FrozenTime::now()->setDate($now->year, $i, 1)->format('M');
            $yearlyTotals[$monthStr] = 0;
        }
        foreach ($yearlyPayments as $p) {
            $monthStr = $p->created->format('M');
            if (isset($yearlyTotals[$monthStr])) $yearlyTotals[$monthStr] += $p->total_payment;
        }

        $methodStats = $paymentsTable->find()
            ->where(['payment_status NOT IN' => ['Pending', 'Failed', 'Cancelled']])
            ->all();
        
        $methodTotals = [];
        foreach ($methodStats as $p) {
            $method = $p->payment_method ?: 'Unknown';
            if (!isset($methodTotals[$method])) {
                $methodTotals[$method] = 0;
            }
            $methodTotals[$method] += $p->total_payment;
        }

        $query = $paymentsTable->find()
            ->contain(['Bookings' => ['Customers']])
            ->order(['Payments.id' => 'DESC']);

        if (!empty($statusFilter)) {
            $query->where(['Payments.payment_status' => $statusFilter]);
        }
        if (!empty($monthFilter)) {
            $startDate = (new FrozenTime($monthFilter . '-01 00:00:00'));
            $endDate = $startDate->modify('last day of this month')->setTime(23, 59, 59);
            $query->where(function ($exp, $q) use ($startDate, $endDate) {
                return $exp->between('Payments.created', $startDate, $endDate);
            });
        }
        if (!empty($search)) {
            $cleanSearchId = (int)str_replace(['#REC-', '#', 'REC-'], '', $search);
            $query->where(['OR' => ['Payments.id' => $cleanSearchId, 'Payments.booking_id' => $cleanSearchId]]);
        }

        $recentPayments = $query->all();

        $this->set(compact('totalRevenue', 'monthlyRevenue', 'pendingAmount', 'recentPayments', 'search', 'statusFilter', 'monthFilter'));
        
        $this->set('chartData', [
            'bar' => [
                'week' => ['labels' => array_keys($weeklyTotals), 'data' => array_values($weeklyTotals)],
                'month' => ['labels' => array_keys($monthlyTotals), 'data' => array_values($monthlyTotals)],
                'year' => ['labels' => array_keys($yearlyTotals), 'data' => array_values($yearlyTotals)],
            ],
            'pieLabels' => array_keys($methodTotals),
            'pieData' => array_values($methodTotals)
        ]);
        
        $this->set('pageTitle', 'Sales & Revenue Report');
    }

    public function receipt($id = null)
    {
        $this->viewBuilder()->disableAutoLayout();
        
        $payment = $this->fetchTable('Payments')->get($id, [
            'contain' => ['Bookings' => ['Customers', 'Cars']]
        ]);
        
        $this->set(compact('payment'));
    }

    public function export()
    {
        $paymentsTable = $this->fetchTable('Payments');
        
        $statusFilter = $this->request->getQuery('status');
        $monthFilter = $this->request->getQuery('month');
        
        $query = $paymentsTable->find()
            ->contain(['Bookings' => ['Customers']])
            ->order(['Payments.id' => 'DESC']);

        if (!empty($statusFilter)) {
            $query->where(['Payments.payment_status' => $statusFilter]);
        }
        if (!empty($monthFilter)) {
            $startDate = (new FrozenTime($monthFilter . '-01 00:00:00'));
            $endDate = $startDate->modify('last day of this month')->setTime(23, 59, 59);
            $query->where(function ($exp, $q) use ($startDate, $endDate) {
                return $exp->between('Payments.created', $startDate, $endDate);
            });
        }

        $payments = $query->all();
        $csvData = "Receipt ID,Booking Ref,Customer Name,Amount (RM),Payment Method,Date,Status\n";
        
        foreach ($payments as $p) {
            $receiptId = '"#REC-' . str_pad($p->id, 4, '0', STR_PAD_LEFT) . '"';
            $bookingRef = '"#' . $p->booking_id . '"';
            $customerName = '"' . ($p->booking->customer->full_name ?? 'N/A') . '"';
            $amount = $p->total_payment;
            $method = '"' . ($p->payment_method ?: 'N/A') . '"';
            $date = '"' . $p->created->format('d M Y, H:i') . '"';
            $status = '"' . $p->payment_status . '"';
            
            $csvData .= "{$receiptId},{$bookingRef},{$customerName},{$amount},{$method},{$date},{$status}\n";
        }

        $fileName = 'Sales_Report_' . date('Ymd_His') . '.csv';
        return $this->response->withStringBody($csvData)
            ->withType('csv')
            ->withDownload($fileName);
    }
}