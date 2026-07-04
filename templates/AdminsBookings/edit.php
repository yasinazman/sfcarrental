<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-form', ['block' => true]); 
?>

<div class="content-header" style="margin-bottom: 24px;">
    <h3 style="margin: 0;">Update Booking #<?= h($booking->id) ?></h3>
    <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">Manage approval status, deposits, and lockbox PIN.</p>
</div>

<div class="form-container">
    <?= $this->Form->create($booking) ?>
    
    <div class="form-grid">
        <div class="form-group">
            <label>Customer Name</label>
            <input type="text" class="form-control" value="<?= h($booking->customer->full_name ?? 'Unknown') ?>" disabled style="background: #f8f9fa;">
        </div>

        <div class="form-group">
            <label>Car Rented</label>
            <input type="text" class="form-control" value="<?= h($booking->car->car_model ?? 'Unknown') ?> (<?= h($booking->car->plate_number ?? '') ?>)" disabled style="background: #f8f9fa;">
        </div>

        <div class="form-group">
            <label>Rental Period</label>
            <input type="text" class="form-control" value="<?= h($booking->start_date->format('d/m/Y')) ?> to <?= h($booking->end_date->format('d/m/Y')) ?>" disabled style="background: #f8f9fa;">
        </div>

        <div class="form-group">
            <label>Total Price (RM)</label>
            <input type="text" class="form-control" value="<?= $this->Number->format($booking->total_price, ['places' => 2]) ?>" disabled style="background: #f8f9fa;">
        </div>

        <div class="form-group full-width" style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 20px;">
            <h4 style="margin: 0 0 15px 0; color: var(--text-main);">Action Required</h4>
        </div>

        <div class="form-group">
            <label>Booking Status</label>
            <?= $this->Form->select('booking_status', [
                'Pending Payment' => 'Pending Payment',
                'Approved' => 'Approved (Active)',
                'Completed' => 'Completed (Returned)',
                'Cancelled' => 'Cancelled'
            ], ['class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <label>Deposit Status</label>
            <?= $this->Form->select('deposit_status', [
                'Pending' => 'Pending',
                'Paid' => 'Paid',
                'Refunded' => 'Refunded'
            ], ['class' => 'form-control']) ?>
        </div>

        <div class="form-group full-width">
            <label>Lockbox PIN <span style="color: var(--text-light); font-size: 12px;">(Provide this to customer for key collection)</span></label>
            <?= $this->Form->text('lockbox_pin', ['class' => 'form-control', 'placeholder' => 'e.g. 1234']) ?>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <?= $this->Form->button('Save Changes', ['class' => 'btn-submit']) ?>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-cancel">Cancel</a>
    </div>

    <?= $this->Form->end() ?>
</div>