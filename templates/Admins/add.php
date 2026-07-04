<?php 
$this->assign('title', 'Add New Administrator'); 
$this->Html->css('admin-form', ['block' => true]); 
?>

<div class="form-container" style="max-width: 500px;">
    <?= $this->Form->create($admin) ?>
    
    <div class="form-group">
        <label>Username</label>
        <?= $this->Form->text('username', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Enter admin username']) ?>
    </div>

    <div class="form-group">
        <label>Password</label>
        <?= $this->Form->password('password', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Enter strong password']) ?>
    </div>

    <div style="margin-top: 20px;">
        <?= $this->Form->button('Create Admin', ['class' => 'btn-submit']) ?>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-cancel">Cancel</a>
    </div>

    <?= $this->Form->end() ?>
</div>