<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
$this->Html->css('admin-bookings', ['block' => true]); 
?>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<div class="maintenance-stats-grid" style="grid-template-columns: repeat(4, 1fr); margin-bottom: 24px;">
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;"><i class="fas fa-clock"></i></div>
        <div class="m-stat-info">
            <h4>Pending Payments</h4>
            <p class="val"><?= h($pendingCount) ?></p>
        </div>
    </div>
    
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;"><i class="fas fa-car-side"></i></div>
        <div class="m-stat-info">
            <h4>Active Rentals</h4>
            <p class="val"><?= h($activeCount) ?></p>
        </div>
    </div>
    
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(23, 162, 184, 0.1); color: #17a2b8;"><i class="fas fa-check-circle"></i></div>
        <div class="m-stat-info">
            <h4>Completed Trips</h4>
            <p class="val"><?= h($completedCount) ?></p>
        </div>
    </div>
    
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(111, 66, 193, 0.1); color: #6f42c1;"><i class="fas fa-wallet"></i></div>
        <div class="m-stat-info">
            <h4>Total Value</h4>
            <p class="val">RM <?= $this->Number->format($totalRevenue, ['places' => 2]) ?></p>
        </div>
    </div>
</div>

<div class="calendar-container">
    <div id="bookingCalendar"></div>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
    
    <div class="category-filter-bar" style="margin: 0; padding: 0;">
        <?php 
        $categories = ['Economy', 'Compact', 'Sedan', 'MPV', 'SUV']; 
        $currentCategory = $this->request->getQuery('category');
        ?>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="badge-status <?= empty($currentCategory) ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">All Categories</a>
        
        <?php foreach($categories as $cat): ?>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['category' => $cat]]) ?>" class="badge-status <?= $currentCategory == $cat ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;"><?= $cat ?></a>
        <?php endforeach; ?>
    </div>

    <div style="display: flex; gap: 15px; align-items: center;">
        <form method="get" action="<?= $this->Url->build(['action' => 'index']) ?>" style="display: flex; gap: 8px; align-items: center; margin: 0;">
            <?php if (!empty($currentCategory)): ?>
                <input type="hidden" name="category" value="<?= h($currentCategory) ?>">
            <?php endif; ?>
            
            <input type="text" name="search" value="<?= h($search ?? '') ?>" placeholder="Search ID or Name..." class="form-control" style="width: 250px; padding: 8px 12px; border-radius: 6px; border: 1px solid #ccc;">
            <button type="submit" style="padding: 8px 15px; border-radius: 6px; background: #007bff; color: white; border: none; cursor: pointer; transition: 0.2s;" title="Search"><i class="fas fa-search"></i></button>
            
            <?php if (!empty($search)): ?>
                <a href="<?= $this->Url->build(['action' => 'index', '?' => ['category' => $currentCategory]]) ?>" style="padding: 8px 15px; text-decoration: none; border-radius: 6px; background: #f8f9fa; border: 1px solid #ccc; color: #dc3545;" title="Clear Search"><i class="fas fa-times"></i></a>
            <?php endif; ?>
        </form>

        <div style="width: 1px; height: 30px; background: #ddd;"></div>

        <a href="<?= $this->Url->build(['action' => 'export', '?' => $this->request->getQuery()]) ?>" style="padding: 8px 15px; border-radius: 6px; background: #28a745; color: white; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s ease, transform 0.2s ease;" onmouseover="this.style.background='#218838'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='#28a745'; this.style.transform='translateY(0)';">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>
    </div>
</div>

<div class="recent-activity dashboard-box">
    <table class="dashboard-table" style="width: 100%;">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Car Details</th>
                <th>Rental Period</th>
                <th>Total Price</th>
                <th>Status</th>
                <th style="text-align: center; min-width: 140px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($bookings->isEmpty()): ?>
            <tr>
                <td colspan="7" class="no-data-text" style="text-align: center; padding: 30px;">
                    <?= !empty($search) ? 'No bookings found matching your search.' : 'No active bookings found in this category.' ?>
                </td>
            </tr>
            <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td style="font-weight: bold;">#<?= h($booking->id) ?></td>
                    <td><?= h($booking->customer->full_name ?? 'Unknown Customer') ?></td>
                    <td>
                        <span style="font-weight: 600; color: var(--text-main);"><?= h($booking->car->car_model ?? 'Unknown Car') ?></span><br>
                        <span style="font-size: 12px; color: #007bff; font-weight: 600;"><?= h($booking->car->plate_number ?? '') ?></span>
                    </td>
                    <td>
                        <div style="font-size: 13px;">
                            <span style="color: #28a745; font-weight: 600;">IN:</span> <?= h($booking->start_date->format('d M Y, h:i A')) ?><br>
                            <span style="color: #dc3545; font-weight: 600;">OUT:</span> <?= h($booking->end_date->format('d M Y, h:i A')) ?>
                        </div>
                    </td>
                    <td style="font-weight: bold;">
                        RM <?= $this->Number->format($booking->total_price, ['places' => 2]) ?>
                    </td>
                    <td>
                        <?php
                            $status = strtolower($booking->booking_status);
                            $badgeClass = 'badge-grey';
                            if (strpos($status, 'pending') !== false) { $badgeClass = 'badge-yellow'; }
                            elseif (strpos($status, 'approved') !== false || strpos($status, 'active') !== false) { $badgeClass = 'badge-green'; }
                            elseif (strpos($status, 'completed') !== false) { $badgeClass = 'badge-blue'; }
                            elseif (strpos($status, 'cancelled') !== false) { $badgeClass = 'badge-red'; }
                        ?>
                        <span class="badge-status <?= $badgeClass ?>">
                            <?= h($booking->booking_status) ?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <div style="display: flex; justify-content: center; align-items: center; gap: 12px;">
                            <a href="<?= $this->Url->build(['action' => 'view', $booking->id]) ?>" style="color: #17a2b8; font-size: 16px;" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= $this->Url->build(['action' => 'edit', $booking->id]) ?>" style="color: #007bff; font-size: 16px;" title="Update Booking">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    window.calendarEvents = <?= json_encode($calendarEvents) ?>;
</script>

<?php 
$this->Html->script('admin-bookings', ['block' => true]); 
?>