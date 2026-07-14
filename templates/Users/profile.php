<?php echo $this->Html->css('user-dashboard'); ?>
<div class="user-dashboard-wrapper">
    <!-- Copy-paste kod Sidebar dari dashboard.php di sini -->

    <div class="content-user">
        <div class="header-user">
            <h1 data-lang-en="My Profile" data-lang-bm="Profil Saya">My Profile</h1>
        </div>

        <div class="table-user-section" style="max-width: 600px;">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label style="color: var(--text-muted-user); font-size: 13px; text-transform: uppercase;">Full Name</label>
                    <p style="font-size: 18px; font-weight: 600; margin-top: 5px;"><?= h($customer->name) ?></p>
                </div>
                <hr style="border-color: var(--border-user);">
                <div>
                    <label style="color: var(--text-muted-user); font-size: 13px; text-transform: uppercase;">Email Address</label>
                    <p style="font-size: 18px; font-weight: 600; margin-top: 5px;"><?= h($customer->email) ?></p>
                </div>
                <hr style="border-color: var(--border-user);">
                <div>
                    <label style="color: var(--text-muted-user); font-size: 13px; text-transform: uppercase;">Phone Number</label>
                    <p style="font-size: 18px; font-weight: 600; margin-top: 5px;"><?= h($customer->phone) ?></p>
                </div>
            </div>
        </div>
    </div>
</div>