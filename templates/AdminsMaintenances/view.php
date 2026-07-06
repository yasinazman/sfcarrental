<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-form', ['block' => true]); 
?>

<div class="content-header view-page-header">
    <div>
        <h3>Maintenance Record #<?= h($maintenance->id) ?></h3>
        <p>Full details of the service rendered.</p>
    </div>
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-cancel btn-back"><i class="fas fa-arrow-left"></i> Back to List</a>
</div>

<div class="form-container view-container">
    
    <div class="view-main-info">
        <div class="service-title-area">
            <h4><?= h($maintenance->service_type) ?></h4>
            <div class="service-date">
                <i class="fas fa-calendar-alt"></i> Service Date: <span><?= h($maintenance->service_date->format('d F Y')) ?></span>
            </div>
        </div>
        <div class="service-status-area">
            <?php
                $status = strtolower($maintenance->status);
                $badgeClass = 'badge-grey';
                if (strpos($status, 'scheduled') !== false) { $badgeClass = 'badge-yellow'; }
                elseif (strpos($status, 'completed') !== false) { $badgeClass = 'badge-green'; }
                elseif (strpos($status, 'in progress') !== false) { $badgeClass = 'badge-blue'; }
            ?>
            <span class="badge-status <?= $badgeClass ?>">
                <?= h($maintenance->status) ?>
            </span>
        </div>
    </div>

    <div class="form-grid view-grid">
        
        <div class="info-card">
            <h5 class="info-card-title">Vehicle Details</h5>
            
            <div class="info-group">
                <span class="info-label">Model</span>
                <span class="info-value"><?= h($maintenance->car->car_model ?? 'Unknown') ?></span>
            </div>
            
            <div class="info-group">
                <span class="info-label">Registration Number</span>
                <span class="info-value text-blue"><?= h($maintenance->car->plate_number ?? 'Unknown') ?></span>
            </div>

            <div class="info-group">
                <span class="info-label">Current Mileage</span>
                <span class="info-value"><?= $maintenance->mileage ? number_format($maintenance->mileage) . ' km' : 'Not Recorded' ?></span>
            </div>
        </div>

        <div class="info-card">
            <h5 class="info-card-title">Cost & Next Schedule</h5>
            
            <div class="info-group">
                <span class="info-label">Total Cost</span>
                <span class="info-value text-green" style="font-size: 18px;">RM <?= $this->Number->format($maintenance->cost, ['places' => 2]) ?></span>
            </div>
            
            <div class="info-group">
                <span class="info-label">Next Due Date</span>
                <span class="info-value">
                    <?= $maintenance->next_service_date ? h($maintenance->next_service_date->format('d F Y')) : 'Not Scheduled' ?>
                </span>
            </div>
        </div>
        
    </div>

    <div class="view-notes-section">
        <h5 class="info-card-title">Description / Notes</h5>
        <div class="notes-box">
            <?= $maintenance->description ? nl2br(h($maintenance->description)) : '<span class="no-notes">No additional notes provided.</span>' ?>
        </div>
    </div>

</div>