<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-form', ['block' => true]); 
?>

<!-- Tambahan CSS sikit untuk buat grid dua lajur supaya borang lebih kemas -->
<style>
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 20px;
    }
    .full-width {
        grid-column: 1 / -1;
    }
</style>

<div class="content-header" style="margin-bottom: 24px;">
    <h3 style="margin: 0;">Register New Vehicle</h3>
    <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">Fill in the full specifications to match the frontend catalog.</p>
</div>

<div class="form-container" style="max-width: 800px;">
    <!-- Wajib tambah 'type' => 'file' untuk membenarkan muat naik gambar -->
    <?= $this->Form->create($car, ['type' => 'file']) ?>
    
    <div class="form-grid">
        <div class="form-group full-width">
            <label>Car Image <span style="color: var(--text-light); font-size: 12px;">(Format: JPG, PNG)</span></label>
            <?= $this->Form->file('image_file', ['class' => 'form-control', 'accept' => 'image/*']) ?>
        </div>

        <div class="form-group">
            <label>Plate Number</label>
            <?= $this->Form->text('plate_number', ['class' => 'form-control', 'placeholder' => 'e.g. VHA 1234', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label>Car Model</label>
            <?= $this->Form->text('car_model', ['class' => 'form-control', 'placeholder' => 'e.g. Perodua Myvi 1.5 Advance', 'required' => true]) ?>
        </div>
        
        <div class="form-group">
            <label>Transmission</label>
            <?= $this->Form->select('transmission', ['Automatic' => 'Automatic', 'Manual' => 'Manual'], ['class' => 'form-control', 'empty' => 'Select Transmission']) ?>
        </div>

        <div class="form-group">
            <label>Engine Capacity (cc)</label>
            <?= $this->Form->text('engine_capacity', ['class' => 'form-control', 'placeholder' => 'e.g. 1500cc']) ?>
        </div>

        <div class="form-group">
            <label>Seat Capacity</label>
            <?= $this->Form->number('seat_capacity', ['class' => 'form-control', 'placeholder' => 'e.g. 5']) ?>
        </div>

        <div class="form-group">
            <label>Baggage Capacity</label>
            <?= $this->Form->number('baggage_capacity', ['class' => 'form-control', 'placeholder' => 'e.g. 2']) ?>
        </div>

        <div class="form-group">
            <label>Fuel Type</label>
            <?= $this->Form->text('fuel_type', ['class' => 'form-control', 'placeholder' => 'e.g. Petrol EEV']) ?>
        </div>

        <div class="form-group">
            <label>Spare Tyre</label>
            <?= $this->Form->text('spare_tyre', ['class' => 'form-control', 'placeholder' => 'e.g. Included']) ?>
        </div>

        <div class="form-group full-width">
            <label>Special Specs</label>
            <?= $this->Form->text('special_specs', ['class' => 'form-control', 'placeholder' => 'e.g. 1.0L Dual VVT-i / ISOFIX Child Seat']) ?>
        </div>

        <div class="form-group">
            <label>Daily Rental Rate (RM)</label>
            <?= $this->Form->number('daily_rate', ['class' => 'form-control', 'placeholder' => 'e.g. 120.00', 'step' => '0.01', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label>Initial Status</label>
            <?= $this->Form->select('availability_status', ['Available' => 'Available', 'Maintenance' => 'Under Maintenance'], ['class' => 'form-control', 'default' => 'Available']) ?>
        </div>
    </div>

    <div style="margin-top: 20px;">
        <?= $this->Form->button('Save Car Details', ['class' => 'btn-submit']) ?>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-cancel">Cancel</a>
    </div>

    <?= $this->Form->end() ?>
</div>