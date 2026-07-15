<div class="profile-container">
    <div class="dashboard-box profile-card">
        
        <h3 class="box-title profile-title">Account Settings</h3>

        <?= $this->Form->create($admin) ?>

        <div class="profile-form-group">
            <label class="profile-label">Username</label>
            <?= $this->Form->control('username', ['label' => false, 'class' => 'form-control profile-input']) ?>
        </div>

        <div class="profile-section-header">
            <h4 class="profile-section-title">Change Password</h4>
            <span class="profile-section-desc">Leave blank if you don't want to change it.</span>
        </div>

        <div class="profile-form-group">
            <label class="profile-label">Current Password</label>
            <?= $this->Form->control('current_password', ['type' => 'password', 'label' => false, 'class' => 'form-control profile-input']) ?>
        </div>

        <div class="profile-form-group mb-30">
            <label class="profile-label">New Password</label>
            <?= $this->Form->control('new_password', ['type' => 'password', 'label' => false, 'class' => 'form-control profile-input']) ?>
        </div>

        <div class="profile-actions">
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Save Changes
            </button>
            
            <a href="<?= $this->Url->build(['controller' => 'AdminsDashboard', 'action' => 'index']) ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>