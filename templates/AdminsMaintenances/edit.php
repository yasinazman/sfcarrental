<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-form', ['block' => true]); 
?>

<div class="form-container view-page-wide">
    <?= $this->Form->create($maintenance) ?>
    
    <div class="form-grid">
        <div class="form-group full-width">
            <label>Select Car</label>
            <?= $this->Form->select('car_id', $cars, ['class' => 'form-control', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label>Service Type</label>
            <?= $this->Form->select('service_type', [
                'Engine Oil Change' => 'Engine Oil Change',
                'Brake Pad Replacement' => 'Brake Pad Replacement',
                'Tyre Replacement' => 'Tyre Replacement',
                'Battery Change' => 'Battery Change',
                'General Inspection' => 'General Inspection',
                'Repair (Other)' => 'Repair (Other)'
            ], ['class' => 'form-control', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label>Status</label>
            <?= $this->Form->select('status', [
                'Completed' => 'Completed',
                'In Progress' => 'In Progress',
                'Scheduled' => 'Scheduled'
            ], ['class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <label>Service Date</label>
            <?= $this->Form->date('service_date', ['class' => 'form-control', 'required' => true]) ?>
        </div>

        <div class="form-group">
            <label>Next Due Date <span style="color: var(--text-light); font-size: 12px;">(Optional)</span></label>
            <?= $this->Form->date('next_service_date', ['class' => 'form-control']) ?>
        </div>

        <div class="form-group">
            <label>Total Cost (RM)</label>
            <?= $this->Form->number('cost', ['class' => 'form-control', 'step' => '0.01', 'min' => '0']) ?>
        </div>

        <div class="form-group">
            <label>Current Mileage (km)</label>
            <?= $this->Form->number('mileage', ['class' => 'form-control', 'min' => '0']) ?>
        </div>

        <div class="form-group full-width">
            <label>Description / Notes <span style="color: var(--text-light); font-size: 12px;">(Optional)</span></label>
            <?= $this->Form->textarea('description', ['class' => 'form-control', 'rows' => '3']) ?>
        </div>
    </div>

    <div style="margin-top: 20px;">
        <?= $this->Form->button('Update Record', ['class' => 'btn-submit']) ?>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-cancel">Cancel</a>
    </div>

    <?= $this->Form->end() ?>
</div>