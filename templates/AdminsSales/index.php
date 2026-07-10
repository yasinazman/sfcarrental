<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
$this->Html->css('admin-sales', ['block' => true]);
$this->Html->script('https://cdn.jsdelivr.net/npm/chart.js', ['block' => true]);
$this->Html->script('admin-sales', ['block' => true]); 
?>

<div id="chartDataContainer" 
     data-bar='<?= json_encode($chartData['bar']) ?>' 
     data-pie-labels='<?= json_encode($chartData['pieLabels']) ?>' 
     data-pie-data='<?= json_encode($chartData['pieData']) ?>' 
     style="display: none;">
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

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 24px;">
    <div class="dashboard-box" style="padding: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h4 id="barChartTitle" style="margin: 0; color: var(--text-main); font-size: 16px;">Revenue Trend (This Month)</h4>
            
            <div class="chart-filter-group">
                <button class="chart-filter-btn" data-filter="week">Week</button>
                <button class="chart-filter-btn active" data-filter="month">Month</button>
                <button class="chart-filter-btn" data-filter="year">Year</button>
            </div>
        </div>
        <canvas id="revenueBarChart" height="100"></canvas>
    </div>
    
    <div class="dashboard-box" style="padding: 20px;">
        <h4 style="margin: 0 0 15px 0; color: var(--text-main); font-size: 16px;">Payment Methods</h4>
        <canvas id="methodPieChart" height="220"></canvas>
    </div>
</div>

<div class="sales-toolbar">
    <div class="sales-filter-row">
        <div class="category-filter-bar sales-badge-bar">
            <?php 
                $currentStatus = $this->request->getQuery('status');
                $currentMonth = $this->request->getQuery('month');
            ?>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['month' => $currentMonth]]) ?>" class="badge-status <?= empty($currentStatus) ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">All Status</a>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => 'Completed', 'month' => $currentMonth]]) ?>" class="badge-status <?= $currentStatus === 'Completed' ? 'badge-green' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">Completed</a>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => 'Pending', 'month' => $currentMonth]]) ?>" class="badge-status <?= $currentStatus === 'Pending' ? 'badge-yellow' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">Pending</a>
        </div>

        <form method="get" action="<?= $this->Url->build(['action' => 'index']) ?>" style="margin: 0; display: flex; gap: 10px; align-items: center;">
            <?php if (!empty($currentStatus)): ?>
                <input type="hidden" name="status" value="<?= h($currentStatus) ?>">
            <?php endif; ?>
            <label style="font-size: 13px; font-weight: 500; color: var(--text-light);">Filter by Month:</label>
            <input type="month" name="month" value="<?= h($currentMonth ?? '') ?>" class="month-selector">
            <button type="submit" style="padding: 7px 12px; border-radius: 6px; background: #6c757d; color: white; border: none; cursor: pointer;">Apply</button>
            <?php if (!empty($currentMonth)): ?>
                <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => $currentStatus]]) ?>" style="padding: 7px 12px; border-radius: 6px; border: 1px solid #ddd; color: #dc3545; text-decoration: none;"><i class="fas fa-times"></i> Clear</a>
            <?php endif; ?>
        </form>
    </div>

    <div class="sales-search-row">
        <form method="get" action="<?= $this->Url->build(['action' => 'index']) ?>" style="display: flex; gap: 8px; align-items: center; margin: 0;">
            <?php if (!empty($currentStatus)): ?><input type="hidden" name="status" value="<?= h($currentStatus) ?>"><?php endif; ?>
            <?php if (!empty($currentMonth)): ?><input type="hidden" name="month" value="<?= h($currentMonth) ?>"><?php endif; ?>
            
            <input type="text" name="search" value="<?= h($search ?? '') ?>" placeholder="Search Receipt ID or Booking Ref..." style="width: 320px; padding: 9px 15px; border-radius: 6px; border: 1px solid #ddd; outline: none;">
            <button type="submit" style="padding: 9px 18px; border-radius: 6px; background: #007bff; color: white; border: none; cursor: pointer;"><i class="fas fa-search"></i></button>
            <?php if (!empty($search)): ?>
                <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => $currentStatus, 'month' => $currentMonth]]) ?>" style="padding: 9px 15px; text-decoration: none; border-radius: 6px; background: #f8f9fa; border: 1px solid #ddd; color: #dc3545;" title="Clear Search"><i class="fas fa-times"></i></a>
            <?php endif; ?>
        </form>

        <a href="<?= $this->Url->build(['action' => 'export', '?' => $this->request->getQuery()]) ?>" class="btn-export">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>
    </div>
</div>

<div class="recent-activity dashboard-box">
    <div class="table-title-area">
        <h3>Payment History</h3>
    </div>
    <table class="dashboard-table" style="width: 100%;">
        <thead>
            <tr>
                <th>Receipt ID</th>
                <th>Booking Ref</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Date</th>
                <th>Status</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($recentPayments->isEmpty()): ?>
            <tr>
                <td colspan="8" class="no-data-text" style="text-align: center; padding: 30px;">
                    <?= !empty($search) || !empty($currentStatus) || !empty($currentMonth) ? 'No payment records found matching your filters.' : 'No payment records found.' ?>
                </td>
            </tr>
            <?php else: ?>
                <?php foreach ($recentPayments as $payment): ?>
                <tr>
                    <td class="id-cell">#REC-<?= str_pad($payment->id, 4, '0', STR_PAD_LEFT) ?></td>
                    <td class="id-cell">
                        <a href="<?= $this->Url->build(['controller' => 'AdminsBookings', 'action' => 'view', $payment->booking_id]) ?>" style="text-decoration: none; color: #007bff;" title="View Booking">
                            #<?= h($payment->booking_id) ?>
                        </a>
                    </td>
                    <td class="name-cell"><?= h($payment->booking->customer->full_name ?? 'N/A') ?></td>
                    <td style="font-weight: 600; color: var(--text-main);">
                        RM <?= $this->Number->format($payment->total_payment, ['places' => 2]) ?>
                    </td>
                    <td><?= h($payment->payment_method ?: '-') ?></td>
                    <td><?= h($payment->created->format('d M Y, h:i A')) ?></td>
                    <td>
                        <?php
                            $status = strtolower($payment->payment_status);
                            $badgeClass = 'badge-grey';
                            if (strpos($status, 'pending') !== false) { $badgeClass = 'badge-yellow'; } 
                            elseif (strpos($status, 'paid') !== false || strpos($status, 'success') !== false || strpos($status, 'completed') !== false) { $badgeClass = 'badge-green'; } 
                            elseif (strpos($status, 'failed') !== false || strpos($status, 'cancelled') !== false) { $badgeClass = 'badge-red'; }
                        ?>
                        <span class="badge-status <?= $badgeClass ?>">
                            <?= h($payment->payment_status) ?>
                        </span>
                    </td>
                    <td class="action-flex">
                        <?php if (strpos($status, 'pending') !== false): ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-check-circle"></i>',
                                ['action' => 'markAsPaid', $payment->id],
                                ['escape' => false, 'class' => 'icon-check', 'title' => 'Mark as Paid (Manual)', 'confirm' => 'Mark Receipt #REC-' . str_pad($payment->id, 4, '0', STR_PAD_LEFT) . ' as Paid?']
                            ) ?>
                            <span style="color: #eee;">|</span>
                        <?php endif; ?>
                        
                        <a href="javascript:void(0);" class="icon-view btn-view-modal" title="Quick View"
                           data-receipt="#REC-<?= str_pad($payment->id, 4, '0', STR_PAD_LEFT) ?>"
                           data-booking="#<?= h($payment->booking_id) ?>"
                           data-customer="<?= h($payment->booking->customer->full_name ?? 'N/A') ?>"
                           data-amount="RM <?= $this->Number->format($payment->total_payment, ['places' => 2]) ?>"
                           data-method="<?= h($payment->payment_method ?: '-') ?>"
                           data-date="<?= h($payment->created->format('d M Y, h:i A')) ?>"
                           data-status="<?= h($payment->payment_status) ?>">
                            <i class="fas fa-eye"></i>
                        </a>
                        
                        <span style="color: #eee;">|</span>
                        
                        <a href="<?= $this->Url->build(['action' => 'receipt', $payment->id]) ?>" target="_blank" style="color: #dc3545; font-size: 18px; transition: transform 0.2s;" title="Save as PDF / Print">
                            <i class="fas fa-file-pdf" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <div id="quickViewModal" class="sales-modal-overlay">
        <div class="sales-modal">
            <div class="modal-header">
                <h3 style="margin:0; font-size: 18px; color: var(--text-main);">Payment Details</h3>
                <button id="closeModalBtn" class="close-btn">&times;</button>
            </div>
            <div class="modal-body">
                <div class="modal-detail-row">
                    <span class="detail-label">Receipt ID:</span>
                    <span class="detail-value" id="modalReceiptId"></span>
                </div>
                <div class="modal-detail-row">
                    <span class="detail-label">Booking Ref:</span>
                    <span class="detail-value" id="modalBookingId"></span>
                </div>
                <div class="modal-detail-row">
                    <span class="detail-label">Customer Name:</span>
                    <span class="detail-value" id="modalCustomer"></span>
                </div>
                <div class="modal-detail-row">
                    <span class="detail-label">Amount Paid:</span>
                    <span class="detail-value" id="modalAmount" style="font-weight: 600; color: #28a745;"></span>
                </div>
                <div class="modal-detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value" id="modalMethod"></span>
                </div>
                <div class="modal-detail-row">
                    <span class="detail-label">Date & Time:</span>
                    <span class="detail-value" id="modalDate"></span>
                </div>
                <div class="modal-detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" id="modalStatus" style="font-weight: 600;"></span>
                </div>
            </div>
        </div>
    </div>
</div>