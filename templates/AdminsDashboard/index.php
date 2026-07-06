<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-header">
            <span>Total Cars</span>
            <div class="stat-icon icon-blue"><i class="fas fa-car"></i></div>
        </div>
        <div class="stat-value"><?= h($totalCars) ?></div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span>Total Customers</span>
            <div class="stat-icon icon-green"><i class="fas fa-users"></i></div>
        </div>
        <div class="stat-value"><?= h($totalCustomers) ?></div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span>Total Bookings</span>
            <div class="stat-icon icon-yellow"><i class="fas fa-calendar-check"></i></div>
        </div>
        <div class="stat-value"><?= h($totalBookings) ?></div>
    </div>
    
    <div class="stat-card">
        <div class="stat-header">
            <span>Today's Rentals</span>
            <div class="stat-icon icon-red"><i class="fas fa-key"></i></div>
        </div>
        <div class="stat-value"><?= h($todayBookings) ?></div>
    </div>
</div>

<div class="charts-container">
    
    <!-- Bar Chart (Booking Trends) -->
    <div class="dashboard-box">
        <div class="box-header">
            <h4 class="box-title">Booking Trends (Last 6 Months)</h4>
            <!-- Butang link ke View Sales atau Manage Bookings -->
            <a href="<?= $this->Url->build(['controller' => 'AdminsSales', 'action' => 'index']) ?>" class="btn-view-details">View Details</a>
        </div>
        <div style="height: 280px; width: 100%;">
            <canvas id="barChart"></canvas>
        </div>
    </div>

    <!-- Pie Chart (Fleet Status) -->
    <div class="dashboard-box">
        <div class="box-header">
            <h4 class="box-title">Fleet Status Overview</h4>
            <!-- Butang link ke Manage Cars -->
            <a href="<?= $this->Url->build(['controller' => 'AdminsCars', 'action' => 'index']) ?>" class="btn-view-details">View Details</a>
        </div>
        <div style="height: 280px; width: 100%;">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

</div>

<!-- Recent Booking -->
<div class="dashboard-box" style="padding-top: 20px;">
    <div class="box-header" style="margin-bottom: 15px;">
        <h3 class="box-title" style="font-size: 18px; font-weight: 600;">Recent Bookings</h3>
        <!-- Butang link ke Manage Bookings -->
        <a href="<?= $this->Url->build(['controller' => 'AdminsBookings', 'action' => 'index']) ?>" class="btn-view-details">View All Bookings</a>
    </div>
    
    <table class="dashboard-table" style="width: 100%;">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Car Details</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($recentBookings->isEmpty()): ?>
            <tr>
                <td colspan="5" class="no-data-text">No recent bookings found.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($recentBookings as $booking): ?>
                <tr>
                    <td class="id-cell">#<?= h($booking->id) ?></td>
                    <td class="name-cell"><?= h($booking->customer->full_name ?? 'Unknown') ?></td>
                    <td>
                        <span class="model-text"><?= h($booking->car->car_model ?? 'Unknown') ?></span><br>
                        <span class="plate-text"><?= h($booking->car->plate_number ?? '') ?></span>
                    </td>
                    <td><?= h($booking->created ? $booking->created->format('d M Y') : 'N/A') ?></td>
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
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    window.dashboardData = {
        monthlyLabels: <?= json_encode($monthlyLabels) ?>,
        monthlyData: <?= json_encode($monthlyData) ?>,
        carStatus: <?= json_encode($carStatusData) ?>
    };
</script>

<?php 
// Panggil fail JS yang baru dicipta
$this->Html->script('admin-dashboard', ['block' => true]); 
?>