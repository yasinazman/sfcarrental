<?php 
$this->assign('title', $pageTitle); 
// Memandangkan ini untuk halaman senarai, kita boleh kongsi fail CSS admin sedia ada
?>

<div class="content-header booking-header">
    <div>
        <h3>Booking Management</h3>
        <p>Monitor and manage customer rentals</p>
    </div>
</div>

<div class="recent-activity">
    <table class="bookings-table">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer Name</th>
                <th>Car Details</th>
                <th>Rental Period</th>
                <th>Total Price</th>
                <th>Status</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($bookings->isEmpty()): ?>
            <tr>
                <td colspan="7" class="no-data">No active bookings found in the system.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td class="booking-id">#<?= h($booking->id) ?></td>
                    <td class="customer-name"><?= h($booking->customer->full_name ?? 'Unknown Customer') ?></td>
                    <td>
                        <span class="car-model"><?= h($booking->car->car_model ?? 'Unknown Car') ?></span><br>
                        <span class="car-plate"><?= h($booking->car->plate_number ?? '') ?></span>
                    </td>
                    <td>
                        <div class="rental-period">
                            <span class="period-in">IN:</span> <?= h($booking->start_date->format('d M Y, h:i A')) ?><br>
                            <span class="period-out">OUT:</span> <?= h($booking->end_date->format('d M Y, h:i A')) ?>
                        </div>
                    </td>
                    <td class="total-price-cell">
                        RM <?= $this->Number->format($booking->total_price, ['places' => 2]) ?>
                    </td>
                    <td>
                        <?php
                            $status = strtolower($booking->booking_status);
                            $statusClass = 'status-grey'; // Default
                            
                            if (strpos($status, 'pending') !== false) {
                                $statusClass = 'status-yellow';
                            } elseif (strpos($status, 'approved') !== false || strpos($status, 'active') !== false) {
                                $statusClass = 'status-green';
                            } elseif (strpos($status, 'completed') !== false) {
                                $statusClass = 'status-blue';
                            } elseif (strpos($status, 'cancelled') !== false) {
                                $statusClass = 'status-red';
                            }
                        ?>
                        <span class="status-badge <?= $statusClass ?>">
                            <?= h($booking->booking_status) ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="<?= $this->Url->build(['action' => 'edit', $booking->id]) ?>" class="btn-edit-action" title="Update Booking">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>