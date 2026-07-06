<?php
namespace App\Controller;

use Cake\I18n\FrozenTime;

class AdminsSalesController extends AppController
{
    public function index()
    {
        $paymentsTable = $this->fetchTable('Payments');

        $totalRevenue = $paymentsTable->find()
            ->where(['payment_status NOT IN' => ['Pending', 'Failed', 'Cancelled']])
            ->all()
            ->sumOf('total_payment');

        $startOfMonth = (new FrozenTime('first day of this month'))->format('Y-m-d 00:00:00');
        $monthlyRevenue = $paymentsTable->find()
            ->where([
                'payment_status NOT IN' => ['Pending', 'Failed', 'Cancelled'],
                'created >=' => $startOfMonth
            ])
            ->all()
            ->sumOf('total_payment');

        $pendingAmount = $paymentsTable->find()
            ->where(['payment_status' => 'Pending'])
            ->all()
            ->sumOf('total_payment');

        $recentPayments = $paymentsTable->find()
            ->contain(['Bookings' => ['Customers']])
            ->order(['Payments.id' => 'DESC'])
            ->all();

        $this->set(compact('totalRevenue', 'monthlyRevenue', 'pendingAmount', 'recentPayments'));
        $this->set('pageTitle', 'Sales & Revenue Report');
    }
}