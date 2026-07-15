<div style="max-width: 500px; margin: 0 auto;">
    <div class="dashboard-box">
        <h3 class="box-title" style="margin-bottom: 20px;">Account Settings</h3>

        <?= $this->Form->create($admin) ?>

        <div style="margin-bottom: 16px;">
            <label style="display:block; margin-bottom:6px; font-size:13px; color:var(--text-light);">Username</label>
            <?= $this->Form->control('username', ['label' => false, 'class' => 'form-control', 'style' => 'width:100%; padding:10px; border-radius:6px;']) ?>
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid rgba(0,0,0,0.08);">

        <h4 style="font-size: 14px; margin-bottom: 16px;">Change Password</h4>

        <div style="margin-bottom: 16px;">
            <label style="display:block; margin-bottom:6px; font-size:13px; color:var(--text-light);">Current Password</label>
            <?= $this->Form->control('current_password', ['type' => 'password', 'label' => false, 'class' => 'form-control', 'style' => 'width:100%; padding:10px; border-radius:6px;']) ?>
        </div>

        <div style="margin-bottom: 16px;">
            <label style="display:block; margin-bottom:6px; font-size:13px; color:var(--text-light);">New Password</label>
            <?= $this->Form->control('new_password', ['type' => 'password', 'label' => false, 'class' => 'form-control', 'style' => 'width:100%; padding:10px; border-radius:6px;']) ?>
        </div>

        <button type="submit" style="padding: 10px 24px; border-radius: 6px; background: var(--accent-red); color: white; border: none; cursor: pointer; font-weight: 500;">
            Save Changes
        </button>

        <?= $this->Form->end() ?>
    </div>
</div>