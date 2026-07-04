<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-layout', ['block' => true]); // Guna css layout utama
?>

<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h3 style="margin: 0;">Admin Users</h3>
        <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">Manage backend access for your team</p>
    </div>
    <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn-add" style="background: var(--accent-red); color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500;"><i class="fas fa-plus"></i> Add New Admin</a>
</div>

<div class="recent-activity">
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Admin ID</th>
                <th>Username</th>
                <th>Created On</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($admins->isEmpty()): ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 30px; color: var(--text-light);">No administrators found.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($admins as $admin): ?>
                <tr>
                    <td style="font-weight: 600;">#<?= h($admin->id) ?></td>
                    <td style="font-weight: 500; color: var(--text-main);">
                        <i class="fas fa-user-circle" style="color: var(--
                        text-light); margin-right: 8px;"></i> <?= h($admin->username) ?>
                    </td>
                    <td><?= h($admin->created->format('d M Y, h:i A')) ?></td>
                    <td style="text-align: center;">
                        <?php if ($admin->id != 1): ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $admin->id],
                                ['confirm' => 'Are you sure you want to delete ' . h($admin->username) . '?', 'escape' => false, 'style' => 'color: var(--accent-red); font-size: 16px;', 'title' => 'Delete Admin']
                            ) ?>
                        <?php else: ?>
                            <span style="font-size: 12px; color: var(--text-light); font-style: italic;">Master Account</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>