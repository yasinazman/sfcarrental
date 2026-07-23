<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
$this->Html->css('customers-dashboard', ['block' => true]);
?>

<div class="dashboard-wrapper">
    <!-- Header Profil (Moden & Bersih) -->
    <div class="profile-card">
        <div class="profile-avatar">
            <?= strtoupper(substr($customer->full_name ?? 'U', 0, 1)) ?>
        </div>
        <div class="profile-info">
            <h2 class="profile-name">Welcome back, <?= h($customer->full_name) ?>!</h2>
            <p class="profile-phone"><i class="fa-solid fa-phone"></i> <?= h($customer->phone_number) ?></p>
        </div>
        <a href="<?= $this->Url->build('/') ?>" class="btn-back-home">
            <i class="fa-solid fa-house"></i> Back to Home
        </a>
    </div>

    <div class="booking-card">
    <h3 class="booking-title"><i class="fa-solid fa-calendar-check"></i> Plan Your Journey</h3>
    
    <!-- Guna tag <form> biasa dan pastikan tutup dengan betul -->
    <form action="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'search']) ?>" method="GET">
        <div class="form-row">
            <div class="input-field">
                <label>Where to?</label>
                <input type="text" name="destination" placeholder="Genting Highlands..." required>
            </div>
            <div class="input-field">
                <label>Vehicle Class</label>
                <!-- Nama input ini ialah 'car_category' -->
                <select name="car_category">
    <option value="all">All Classes</option>
    <option value="Economy">Economy</option>
    <option value="Compact">Compact</option>
    <option value="Sedan">Sedan</option>
    <option value="MPV">MPV</option>
    <option value="SUV">SUV</option>
</select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="input-field">
                <label>Pick-up Date</label>
                <input type="datetime-local" name="pickup_date" required>
            </div>
            <div class="input-field">
                <label>Return Date</label>
                <input type="datetime-local" name="return_date" required>
            </div>
            <div class="form-group">
                <label>Pickup Location </label>
                <select name="pickup_location" required>
                    <option value="">Select Location...</option>
                    <option value="SF HQ">SF Car Rental HQ</option>
                    <option value="I-CITY">I-City Shah Alam</option>
                    <option value="AEON">AEON Mall Shah Alam</option>
                </select>
            </div>
            <div class="form-group">
                <label>Drop Off Location</label>
                <select name="dropoff_location" required>
                    <option value="">Select Location...</option>
                    <option value="SF HQ">SF Car Rental HQ</option>
                    <option value="I-CITY">I-City Shah Alam</option>
                    <option value="AEON">AEON Mall Shah Alam</option>
                </select>
            </div>
        </div>
        
        <!-- Butang submit diletakkan terus di dalam <form> -->
        <button type="submit" class="btn-search-main">Search Available Cars</button>
    </form>
</div>

    <!-- Sejarah Tempahan -->
    <div class="history-section">
        <h3 class="section-title"><i class="fa-solid fa-clock-history"></i> Your Rental History</h3>

        <?php if ($bookings->isEmpty()): ?>
            <div class="empty-booking-state">
                <i class="fa-solid fa-car-rear empty-icon"></i>
                <p class="empty-text">You don't have any bookings yet.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>Car Details</th>
                            <th>Rental Period</th>
                            <th>Smart-Pin</th>
                            <th>Pricing</th>
                            <th>Status</th>
                            <th>Action</th> <!-- TAMBAH COLUMN BARU DI SINI -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><strong><?= h($booking->car->brand ?? 'Car') ?></strong></td>
                                <td><?= h($booking->start_date ? $booking->start_date->format('d M Y') : '-') ?></td>
                                <td><span class="pin-box"><?= h($booking->lockbox_pin ?? '-') ?></span></td>
                                <td>RM <?= number_format((float)$booking->total_price, 2) ?></td>
                                <td><span class="badge-status"><?= h($booking->booking_status ?? 'Pending') ?></span></td>
                                <td>
                                    <!-- LOGIK BUTANG EXTEND BERMULA DI SINI -->
                                    <?php if ($booking->booking_status === 'Confirmed'): ?>
                                        <a href="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'extend', $booking->id]) ?>" 
                                           style="background-color: #ffc107; color: #000; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 13px; font-weight: bold; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                            <i class="fa-solid fa-clock"></i> Extend
                                        </a>
                                    <?php else: ?>
                                        <span style="color: #999; font-size: 13px;">-</span>
                                    <?php endif; ?>
                                    <!-- LOGIK BUTANG EXTEND TAMAT DI SINI -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>