<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
?>

<div class="booking-header">
    <div>
        <h3 style="margin: 0; font-size: 22px; color: var(--text-main);">Maintenance Records</h3>
        <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">Monitor service schedules and repair costs.</p>
    </div>
    <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="badge-status badge-blue" style="font-size: 14px; padding: 10px 20px; text-decoration: none;">
        <i class="fas fa-plus"></i> Add New Record
    </a>
</div>

<div class="recent-activity" style="margin-top: 24px;">
    <table class="dashboard-table">
        <thead>
            <tr>
                <th>Car Details</th>
                <th>Service Type</th>
                <th>Cost</th>
                <th>Mileage</th>
                <th>Service Date</th>
                <th>Next Due Date</th>
                <th>Status</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($maintenances->isEmpty()): ?>
            <tr>
                <td colspan="6" class="no-data-text">No maintenance records found.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($maintenances as $record): ?>
                <tr>
                    <td>
                        <span class="name-cell"><?= h($record->car->car_model ?? 'Unknown') ?></span><br>
                        <span class="plate-text"><?= h($record->car->plate_number ?? '') ?></span>
                    </td>
                    <td style="font-weight: 500; color: var(--text-main);">
                        <?= h($record->service_type) ?>
                    </td>
                    <td class="id-cell">
                        RM <?= $this->Number->format($record->cost, ['places' => 2]) ?>
                    </td>
                    <td>
                        <?= $record->mileage ? number_format($record->mileage) . ' km' : '<span style="color:#aaa;">-</span>' ?>
                    </td>
                    <td><?= h($record->service_date->format('d M Y')) ?></td>
                    <td>
                        <?= $record->next_service_date ? h($record->next_service_date->format('d M Y')) : '<span style="color:#aaa;">N/A</span>' ?>
                    </td>
                    <td>
                        <?php
                            $status = strtolower($record->status);
                            $badgeClass = 'badge-grey';
                            
                            if (strpos($status, 'scheduled') !== false) {
                                $badgeClass = 'badge-yellow';
                            } elseif (strpos($status, 'completed') !== false) {
                                $badgeClass = 'badge-green';
                            } elseif (strpos($status, 'in progress') !== false) {
                                $badgeClass = 'badge-blue';
                            }
                        ?>
                        <span class="badge-status <?= $badgeClass ?>">
                            <?= h($record->status) ?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="<?= $this->Url->build(['action' => 'view', $record->id]) ?>" style="color: #17a2b8; margin-right: 15px; font-size: 16px;" title="View Full Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?= $this->Url->build(['action' => 'edit', $record->id]) ?>" style="color: #007bff; margin-right: 15px; font-size: 16px;" title="Edit Record">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?= $this->Form->postLink(
                            '<i class="fas fa-trash"></i>',
                            ['action' => 'delete', $record->id],
                            ['confirm' => 'Are you sure you want to delete this maintenance record?', 'escape' => false, 'style' => 'color: var(--accent-red); font-size: 16px;', 'title' => 'Delete Record']
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>