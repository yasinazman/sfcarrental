<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-form', ['block' => true]); 
?>

<div class="form-container" style="max-width: 800px;">
    <?= $this->Form->create($customer, ['type' => 'file']) ?>
    
    <div class="car-form-grid">
        <div class="form-group full-width">
            <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; color: var(--text-main);"><i class="fas fa-user-circle"></i> Personal Information</h4>
        </div>

        <div class="form-group">
            <label>Full Name</label>
            <?= $this->Form->text('full_name', ['class' => 'form-control', 'required' => true, 'placeholder' => 'e.g. Ahmad Albab']) ?>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <?= $this->Form->text('phone_number', ['class' => 'form-control', 'required' => true, 'placeholder' => 'e.g. 012-3456789']) ?>
        </div>

        <div class="form-group full-width">
            <label>Temporary Password <span style="color: var(--text-light); font-size: 12px;">(For customer frontend login)</span></label>
            <?= $this->Form->password('password', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Set a temporary password for the customer']) ?>
        </div>

        <div class="form-group full-width" style="margin-top: 15px;">
            <h4 style="border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; color: var(--text-main);"><i class="fas fa-file-upload"></i> Verification Documents (Optional)</h4>
        </div>

        <div class="form-group">
            <label>Identity Card (Front)</label>
            <?= $this->Form->file('ic_file', ['class' => 'form-control', 'accept' => 'image/*']) ?>
        </div>

        <div class="form-group">
            <label>Identity Card (Back)</label>
            <?= $this->Form->file('ic_back_file', ['class' => 'form-control', 'accept' => 'image/*']) ?>
        </div>

        <div class="form-group full-width">
            <label>Driving License</label>
            <?= $this->Form->file('license_file', ['class' => 'form-control', 'accept' => 'image/*']) ?>
        </div>
        
        <?= $this->Form->hidden('account_status', ['value' => 'Active']) ?>
    </div>

    <div style="margin-top: 30px;">
        <?= $this->Form->button('Register Customer', ['class' => 'btn-submit']) ?>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-cancel">Cancel</a>
    </div>

    <?= $this->Form->end() ?>
</div>