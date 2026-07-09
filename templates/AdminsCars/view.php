<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-form', ['block' => true]); 
?>

<div class="content-header view-page-header">
    <div>
        <h3><?= h($car->car_model) ?></h3>
        <p><?= h($car->plate_number) ?></p>
    </div>
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-cancel btn-back"><i class="fas fa-arrow-left"></i> Back to Fleet</a>
</div>

<div class="form-container car-view-container">
    
    <div style="text-align: center;">
        <?php if (!empty($car->image)): ?>
            <img src="<?= $this->Url->image('cars/' . $car->image) ?>" alt="Car" class="car-image-main">
        <?php else: ?>
            <div class="car-no-image-main">No Image Available</div>
        <?php endif; ?>
        
        <h4 class="car-price-tag">RM <?= $this->Number->format($car->daily_rate, ['places' => 2]) ?> <span style="font-size: 14px; color: #666;">/ Day</span></h4>
        
        <?php $badgeClass = $car->availability_status === 'Available' ? 'badge-green' : 'badge-red'; ?>
        <div class="badge-status <?= $badgeClass ?>" style="padding: 10px; font-size: 14px;">
            Status: <?= h($car->availability_status) ?>
        </div>
    </div>

    <div class="car-specs-card">
        <h5 class="info-card-title" style="border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 20px;">Full Specifications</h5>
        
        <div class="car-specs-grid">
            <div class="info-group">
                <span class="info-label">Category</span>
                <span class="info-value text-blue"><?= h($car->category ?: 'Uncategorized') ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Transmission</span>
                <span class="info-value"><?= h($car->transmission ?: 'N/A') ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Engine Capacity</span>
                <span class="info-value"><?= h($car->engine_capacity ?: 'N/A') ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Fuel Type</span>
                <span class="info-value"><?= h($car->fuel_type ?: 'N/A') ?></span>
            </div>
            <div class="info-group">
                <span class="info-label">Seat Capacity</span>
                <span class="info-value"><?= h($car->seat_capacity ?: '-') ?> Seats</span>
            </div>
            <div class="info-group">
                <span class="info-label">Baggage Capacity</span>
                <span class="info-value"><?= h($car->baggage_capacity ?: '-') ?> Bags</span>
            </div>
            <div class="info-group">
                <span class="info-label">Spare Tyre</span>
                <span class="info-value"><?= h($car->spare_tyre ?: 'N/A') ?></span>
            </div>
        </div>

        <div class="spec-divider">
            <span class="info-label">Special Specs</span>
            <p style="margin: 0; font-size: 14px; line-height: 1.6; color: #444;">
                <?= $car->special_specs ? nl2br(h($car->special_specs)) : '<span class="no-notes">No special specifications listed.</span>' ?>
            </p>
        </div>
    </div>
</div>