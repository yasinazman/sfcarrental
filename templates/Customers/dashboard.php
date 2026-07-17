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
    <form action="<?= $this->Url->build(['controller' => 'Cars', 'action' => 'search']) ?>" method="GET">
        <div class="form-row">
            <div class="input-field">
                <label>Where to?</label>
                <input type="text" name="destination" placeholder="Genting Highlands..." required>
            </div>
            <div class="input-field">
                <label>Vehicle Class</label>
                <select name="car_category">
                    <option value="all">All Classes</option>
                    <option value="economy">Economy</option>
                    <option value="compact">Compact</option>
                    <option value="sedan">Sedan</option>
                    <option value="mpv">MPV</option>
                    <option value="suv">SUV</option>
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
                        <option value="" data-en="Select Location..." data-bm="Pilih Lokasi...">Select Location...</option>
                        <option value="SF HQ">SF Car Rental HQ</option>
                        <option value="I-CITY">I-City Shah Alam</option>
                        <option value="AEON">AEON Mall Shah Alam</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Drop Off Location</label>
                    <select name="dropoff_location" required>
                        <option value="" data-en="Select Location..." data-bm="Pilih Lokasi...">Select Location...</option>
                        <option value="SF HQ">SF Car Rental HQ</option>
                        <option value="I-CITY">I-City Shah Alam</option>
                        <option value="AEON">AEON Mall Shah Alam</option>
                    </select>
                </div>
        </div>
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
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>