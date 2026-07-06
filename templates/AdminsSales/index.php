<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
?>

<div class="content-header" style="margin-bottom: 24px;">
    <h3 style="margin: 0; font-size: 22px; color: var(--text-main);">Financial Overview</h3>
    <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">Track your rental revenue and payment statuses.</p>
</div>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-header">
            <span>Total Revenue</span>
            <div class="stat-icon icon-green"><i class="fas fa-money-bill-wave"></i></div>
        </div>
        <div class="stat-value" style="color: #28a745;">RM <?= $this->Number->format($totalRevenue ?? 0, ['places' => 2]) ?></div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span>This Month's Sales</span>
            <div class="stat-icon icon-blue"><i class="fas fa-chart-line"></i></div>
        </div>
        <div class="stat-value">RM <?= $this->Number->format($monthlyRevenue ?? 0, ['places' => 2]) ?></div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span>Pending Collections</span>
            <div class="stat-icon icon-yellow"><i class="fas fa-clock"></i></div>
        </div>
        <div class="stat-value">RM <?= $this->Number->format($pendingAmount ?? 0, ['places' => 2]) ?></div>
    </div>
</div>

<div class="recent-activity">
    <div class="table-title-area">
        <h3>Payment History</h3>
    </div>
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Receipt ID</th>
                <th>Booking Ref</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($recentPayments->isEmpty()): ?>
            <tr>
                <td colspan="7" class="no-data-text">No payment records found.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($recentPayments as $payment): ?>
                <tr>
                    <td class="id-cell">#REC-<?= str_pad($payment->id, 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="id-cell">
                        <a href="<?= $this->Url->build(['controller' => 'AdminsBookings', 'action' => 'edit', $payment->booking_id]) ?>" style="text-decoration: none; color: #007bff;" title="View Booking">
                            #<?= h($payment->booking_id) ?>
                        </a>
                    </td>
                    <td class="name-cell"><?= h($payment->booking->customer->full_name ?? 'N/A') ?></td>
                    <td style="font-weight: 600; color: var(--text-main);">
                        RM <?= $this->Number->format($payment->total_payment, ['places' => 2]) ?>
                    </td>
                    <td>
                        <?= h($payment->payment_method ?: '-') ?>
                    </td>
                    <td><?= h($payment->created->format('d M Y, h:i A')) ?></td>
                    <td>
                        <?php
                            $status = strtolower($payment->payment_status);
                            $badgeClass = 'badge-grey';
                            
                            if (strpos($status, 'pending') !== false) {
                                $badgeClass = 'badge-yellow';
                            } elseif (strpos($status, 'paid') !== false || strpos($status, 'success') !== false || strpos($status, 'completed') !== false) {
                                $badgeClass = 'badge-green';
                            } elseif (strpos($status, 'failed') !== false || strpos($status, 'cancelled') !== false) {
                                $badgeClass = 'badge-red';
                            }
                        ?>
                        <span class="badge-status <?= $badgeClass ?>">
                            <?= h($payment->payment_status) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>