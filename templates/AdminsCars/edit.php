<?php 
$this->assign('title', $pageTitle); 

// Panggil fail CSS berpusat yang dah dikemaskini
$this->Html->css('admin-form', ['block' => true]); 
?>

<div class="content-header" style="margin-bottom: 24px;">
    <h3 style="margin: 0;">Edit Vehicle Details</h3>
    <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">Update the specifications or change the car image.</p>
</div>

<div class="form-container">
    <?= $this->Form->create($car, ['type' => 'file']) ?>
    
    <div class="form-grid">
        <div class="form-group full-width">
            <label>Car Image <span style="color: var(--text-light); font-size: 12px;">(Leave blank to keep current image)</span></label>
            <?= $this->Form->file('image_file', ['class' => 'form-control', 'accept' => 'image/*']) ?>
            
            <?php if (!empty($car->image)): ?>
                <div class="current-image">
                    <span style="font-size: 11px; color: var(--text-light); margin-bottom: 5px; display: block;">Current Image:</span>
                    <img src="<?= $this->Url->image('cars/' . $car->image) ?>" alt="Current Car Image">
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Plate Number</label>
            <?= $this->Form->text('plate_number', ['class' => 'form-control', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label>Car Model</label>
            <?= $this->Form->text('car_model', ['class' => 'form-control', 'required' => true]) ?>
        </div>
        
        <div class="form-group">
            <label>Transmission</label>
            <?= $this->Form->select('transmission', ['Automatic' => 'Automatic', 'Manual' => 'Manual'], ['class' => 'form-control', 'empty' => 'Select Transmission']) ?>
        </div>

        <div class="form-group">
            <label>Engine Capacity (cc)</label>
            <?= $this->Form->text('engine_capacity', ['class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <label>Seat Capacity</label>
            <?= $this->Form->number('seat_capacity', ['class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <label>Baggage Capacity</label>
            <?= $this->Form->number('baggage_capacity', ['class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <label>Fuel Type</label>
            <?= $this->Form->text('fuel_type', ['class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <label>Spare Tyre</label>
            <?= $this->Form->text('spare_tyre', ['class' => 'form-control']) ?>
        </div>

        <div class="form-group full-width">
            <label>Special Specs</label>
            <?= $this->Form->text('special_specs', ['class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <label>Daily Rental Rate (RM)</label>
            <?= $this->Form->number('daily_rate', ['class' => 'form-control', 'step' => '0.01', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label>Status</label>
            <?= $this->Form->select('availability_status', ['Available' => 'Available', 'Maintenance' => 'Under Maintenance'], ['class' => 'form-control']) ?>
        </div>
    </div>

    <div style="margin-top: 20px;">
        <?= $this->Form->button('Update Car Details', ['class' => 'btn-submit']) ?>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-cancel">Cancel</a>
    </div>

    <?= $this->Form->end() ?>
</div>