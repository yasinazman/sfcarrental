<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
$this->Html->css('admin-admins', ['block' => true]); 
$this->Html->script('admin-admins', ['block' => true]);
?>

<div class="maintenance-stats-grid admin-stats-grid">
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(0, 123, 255, 0.1); color: #007bff;"><i class="fas fa-users-cog"></i></div>
        <div class="m-stat-info">
            <h4>Total Accounts</h4>
            <p class="val"><?= h($totalAdmins) ?></p>
        </div>
    </div>
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;"><i class="fas fa-crown"></i></div>
        <div class="m-stat-info">
            <h4>Master Privileges</h4>
            <p class="val"><?= h($masterCount) ?></p>
        </div>
    </div>
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;"><i class="fas fa-user-lock"></i></div>
        <div class="m-stat-info">
            <h4>Suspended</h4>
            <p class="val"><?= h($suspendedCount) ?></p>
        </div>
    </div>
</div>

<div class="admin-search-wrapper" style="align-items: center; gap: 15px;">
    <input type="text" id="adminLiveSearch" class="admin-search-input" placeholder="Quick search by username or ID...">

    <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn-add-admin">
        <i class="fas fa-user-shield"></i> Add New Admin
    </a>
</div>

<div class="recent-activity dashboard-box">
    <table class="dashboard-table" style="width: 100%;">
        <thead>
            <tr>
                <th>Administrator</th>
                <th>Role & Status</th>
                <th>Last Login Session</th>
                <th>Created On</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody id="adminsTableBody">
            <?php if ($admins->isEmpty()): ?>
            <tr>
                <td colspan="5" class="no-data-text" style="text-align: center; padding: 30px;">No administrators found.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($admins as $admin): ?>
                <tr>
                    <td>
                        <div class="admin-user-flex">
                            <?php 
                                $initial = strtoupper(substr($admin->username, 0, 1));
                                $avatarClass = ($admin->id == 1) ? 'avatar-master' : 'avatar-staff';
                            ?>
                            
                            <div class="admin-avatar <?= $avatarClass ?>">
                                <?= $initial ?>
                            </div>
                            
                            <div>
                                <div class="admin-username">
                                    <?= h($admin->username) ?>
                                </div>
                                <?php if ($admin->id == 1): ?>
                                    <div class="master-tag">
                                        <i class="fas fa-star"></i> MASTER ACCOUNT : MUHAMMAD YASIN BIN AZMAN
                                    </div>
                                <?php else: ?>
                                    <div class="staff-id">ID: #<?= h($admin->id) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php 
                            $roleClass = ($admin->role === 'Master') ? 'badge-yellow' : 'badge-blue';
                            $statusClass = ($admin->status === 'Suspended') ? 'badge-red' : 'badge-green';
                        ?>
                        <div class="role-badge-group">
                            <span class="badge-status <?= $roleClass ?> badge-small"><i class="<?= ($admin->role === 'Master') ? 'fas fa-crown' : 'fas fa-user-tie' ?>"></i> <?= h($admin->role) ?></span>
                            <span class="badge-status <?= $statusClass ?> badge-small"><?= h($admin->status) ?></span>
                        </div>
                    </td>
                    <td>
                        <?php if (!empty($admin->last_login)): ?>
                            <span class="login-time"><i class="fas fa-clock"></i><?= h($admin->last_login->format('d M Y, h:i A')) ?></span>
                        <?php else: ?>
                            <span class="login-never">Never Logged In</span>
                        <?php endif; ?>
                    </td>
                    <td><span class="created-date"><?= h($admin->created->format('d M Y')) ?></span></td>
                    <td class="action-flex">
                        <?php if ($admin->id != 1): ?>
                            
                            <?= $this->Form->postLink(
                                $admin->status === 'Suspended' ? '<i class="fas fa-unlock"></i>' : '<i class="fas fa-user-lock"></i>',
                                ['action' => 'toggleStatus', $admin->id],
                                [
                                    'escape' => false, 
                                    'class' => $admin->status === 'Suspended' ? 'icon-activate' : 'icon-suspend', 
                                    'title' => $admin->status === 'Suspended' ? 'Restore Access' : 'Suspend Account',
                                    'confirm' => 'Are you sure you want to change access for ' . h($admin->username) . '?'
                                ]
                            ) ?>
                            
                            <span class="action-divider">|</span>
                            
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $admin->id],
                                ['confirm' => 'Permanently delete ' . h($admin->username) . '?', 'escape' => false, 'class' => 'icon-delete', 'title' => 'Delete Admin']
                            ) ?>
                            
                        <?php else: ?>
                            <span class="icon-shield" title="Protected System Account"><i class="fas fa-shield-alt"></i></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>