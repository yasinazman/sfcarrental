<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-form', ['block' => true]); 
$this->Html->css('admin-bookings', ['block' => true]); 
?>

<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h3 style="margin: 0;">Booking #<?= h($booking->id) ?></h3>
        <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">Submitted on <?= h($booking->created->format('d F Y')) ?></p>
    </div>
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-cancel" style="padding: 10px 20px; text-decoration: none;"><i class="fas fa-arrow-left"></i> Back to List</a>
</div>

<div class="form-container view-page-wide" style="padding: 0;">
    
    <?php
        $status = strtolower($booking->booking_status);
        $bannerColor = '#6c757d'; // Grey
        if (strpos($status, 'pending') !== false) $bannerColor = '#ffc107';
        elseif (strpos($status, 'approved') !== false || strpos($status, 'active') !== false) $bannerColor = '#28a745';
        elseif (strpos($status, 'cancelled') !== false) $bannerColor = '#dc3545';
    ?>
    <div style="background: <?= $bannerColor ?>; color: white; padding: 15px 30px; border-radius: 8px 8px 0 0; font-weight: 600; font-size: 16px; display: flex; justify-content: space-between;">
        <span>Current Status: <?= h($booking->booking_status) ?></span>
        <span>Payment: <?= h($booking->deposit_status ?? 'N/A') ?></span>
    </div>

    <div class="booking-view-grid">
        
        <div class="detail-card">
            <h4 class="detail-header"><i class="fas fa-user"></i> Customer Information</h4>
            <div style="margin-bottom: 12px;">
                <span style="color: var(--text-light); font-size: 13px; display: block;">Full Name</span>
                <span style="font-weight: 600; font-size: 15px;"><?= h($booking->customer->full_name ?? 'N/A') ?></span>
            </div>
            <div style="margin-bottom: 12px;">
                <span style="color: var(--text-light); font-size: 13px; display: block;">Phone Number</span>
                <span style="font-weight: 600; font-size: 15px; color: #007bff;"><?= h($booking->customer->phone_number ?? 'N/A') ?></span>
            </div>
            <div>
                <span style="color: var(--text-light); font-size: 13px; display: block;">Email Address</span>
                <span style="font-weight: 600; font-size: 15px;"><?= h($booking->customer->email ?? 'N/A') ?></span>
            </div>
        </div>

        <div class="detail-card">
            <h4 class="detail-header"><i class="fas fa-car"></i> Vehicle Details</h4>
            <div style="margin-bottom: 12px;">
                <span style="color: var(--text-light); font-size: 13px; display: block;">Car Model</span>
                <span style="font-weight: 600; font-size: 15px;"><?= h($booking->car->car_model ?? 'N/A') ?></span>
            </div>
            <div style="margin-bottom: 12px;">
                <span style="color: var(--text-light); font-size: 13px; display: block;">Registration Plate</span>
                <span style="font-weight: 600; font-size: 15px; background: #eee; padding: 2px 8px; border-radius: 4px;"><?= h($booking->car->plate_number ?? 'N/A') ?></span>
            </div>
            <div>
                <span style="color: var(--text-light); font-size: 13px; display: block;">Lockbox PIN (If Applicable)</span>
                <span style="font-weight: 600; font-size: 15px; letter-spacing: 2px;"><?= h($booking->lockbox_pin ?: 'Not Set') ?></span>
            </div>
        </div>

        <div class="detail-card">
            <h4 class="detail-header"><i class="fas fa-calendar-alt"></i> Rental Schedule</h4>
            <div style="margin-bottom: 15px; background: rgba(40, 167, 69, 0.1); padding: 10px; border-left: 4px solid #28a745; border-radius: 4px;">
                <span style="color: #28a745; font-size: 12px; font-weight: bold; display: block;">PICK-UP (IN)</span>
                <span style="font-weight: 600; font-size: 16px;"><?= h($booking->start_date->format('l, d F Y')) ?></span><br>
                <span style="color: #555; font-size: 14px;"><i class="far fa-clock"></i> <?= h($booking->start_date->format('h:i A')) ?></span>
            </div>
            <div style="background: rgba(220, 53, 69, 0.1); padding: 10px; border-left: 4px solid #dc3545; border-radius: 4px;">
                <span style="color: #dc3545; font-size: 12px; font-weight: bold; display: block;">DROP-OFF (OUT)</span>
                <span style="font-weight: 600; font-size: 16px;"><?= h($booking->end_date->format('l, d F Y')) ?></span><br>
                <span style="color: #555; font-size: 14px;"><i class="far fa-clock"></i> <?= h($booking->end_date->format('h:i A')) ?></span>
            </div>
        </div>

        <div class="detail-card">
            <h4 class="detail-header"><i class="fas fa-file-invoice-dollar"></i> Financial Summary</h4>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; border-bottom: 1px dashed #ddd; padding-bottom: 8px;">
                <span style="color: var(--text-light);">Rental Price</span>
                <span style="font-weight: 600;">RM <?= $this->Number->format($booking->rental_price, ['places' => 2]) ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 12px; border-bottom: 1px dashed #ddd; padding-bottom: 8px;">
                <span style="color: var(--text-light);">Security Deposit</span>
                <span style="font-weight: 600;">RM <?= $this->Number->format($booking->deposit_amount, ['places' => 2]) ?></span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 15px; background: #e8f4fd; padding: 10px; border-radius: 6px;">
                <span style="color: #007bff; font-weight: bold; font-size: 16px;">Total Amount</span>
                <span style="font-weight: bold; font-size: 18px; color: #007bff;">RM <?= $this->Number->format($booking->total_price, ['places' => 2]) ?></span>
            </div>
        </div>
        
    </div>
</div>