<?php $this->assign('title', $pageTitle); ?>

<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h3 style="margin: 0;">Customer Database</h3>
        <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">View and manage registered clients</p>
    </div>
</div>

<div class="recent-activity">
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>IC Document</th>
                <th>Driving License</th>
                <th>Registered On</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($customers->isEmpty()): ?>
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-light);">No customers have registered yet.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td style="font-weight: 600; color: var(--text-main);"><?= h($customer->full_name) ?></td>
                    <td><?= h($customer->phone_number) ?></td>
                    <td>
                        <?php if (!empty($customer->ic_file_path)): ?>
                            <a href="<?= $this->Url->image('customers/' . $customer->ic_file_path) ?>" target="_blank" style="color: #007bff; text-decoration: none; font-size: 13px; font-weight: 500;">
                                <i class="fas fa-id-card"></i> View IC
                            </a>
                        <?php else: ?>
                            <span style="color: #999; font-size: 12px; font-style: italic;">Pending Upload</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($customer->license_file_path)): ?>
                            <a href="<?= $this->Url->image('customers/' . $customer->license_file_path) ?>" target="_blank" style="color: #007bff; text-decoration: none; font-size: 13px; font-weight: 500;">
                                <i class="fas fa-id-badge"></i> View License
                            </a>
                        <?php else: ?>
                            <span style="color: #999; font-size: 12px; font-style: italic;">Pending Upload</span>
                        <?php endif; ?>
                    </td>
                    <td><?= h($customer->created->format('d M Y')) ?></td>
                    <td style="text-align: center;">
                        <?= $this->Form->postLink(
                            '<i class="fas fa-trash"></i>',
                            ['action' => 'delete', $customer->id],
                            ['confirm' => 'Are you sure you want to permanently delete ' . h($customer->full_name) . '?', 'escape' => false, 'style' => 'color: var(--accent-red); font-size: 16px;', 'title' => 'Delete']
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>