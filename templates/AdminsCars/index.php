<?php $this->assign('title', $pageTitle); ?>

<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <div>
        <h3 style="margin: 0;">Car Fleet</h3>
        <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">Manage your rental vehicles</p>
    </div>
    <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn-add" style="background: var(--accent-red); color: white; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: 500;"><i class="fas fa-plus"></i> Add New Car</a>
</div>

<div class="recent-activity">
    <table>
        <thead>
            <tr>
                <th>No. Plate</th>
                <th>Car Details</th>
                <th>Engine (cc)</th>
                <th>Rate / Day</th>
                <th>Status</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($cars->isEmpty()): ?>
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-light);">No cars found in the database. Click 'Add New Car' to begin.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($cars as $car): ?>
                <tr>
                    <td style="font-weight: 600;"><?= h($car->plate_number) ?></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <?php if (!empty($car->image)): ?>
                                <img src="<?= $this->Url->image('cars/' . $car->image) ?>" alt="Car" style="width: 70px; height: 45px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            <?php else: ?>
                                <div style="width: 70px; height: 45px; background: #f0f0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; color: #999;">No Image</div>
                            <?php endif; ?>
                            <div>
                                <div style="font-weight: 600; color: var(--text-main);"><?= h($car->car_model) ?></div>
                                <div style="font-size: 12px; color: var(--text-light);">
                                    <?= h($car->transmission ?: 'N/A') ?> • <?= h($car->seat_capacity ?: '-') ?> Seats
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><?= h($car->engine_capacity ?: 'N/A') ?></td>
                    <td style="color: var(--accent-red); font-weight: 600;">RM <?= $this->Number->format($car->daily_rate, ['places' => 2]) ?></td>
                    <td>
                        <?php 
                            $badgeColor = $car->availability_status === 'Available' ? '#28a745' : '#dc3545';
                            $badgeBg = $car->availability_status === 'Available' ? 'rgba(40, 167, 69, 0.1)' : 'rgba(220, 53, 69, 0.1)';
                        ?>
                        <span style="padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; background: <?= $badgeBg ?>; color: <?= $badgeColor ?>;">
                            <?= h($car->availability_status) ?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="<?= $this->Url->build(['action' => 'edit', $car->id]) ?>" style="color: #007bff; margin-right: 15px; font-size: 16px;" title="Edit"><i class="fas fa-edit"></i></a>
                        
                        <?= $this->Form->postLink(
                            '<i class="fas fa-trash"></i>',
                            ['action' => 'delete', $car->id],
                            ['confirm' => 'Are you sure you want to delete ' . h($car->car_model) . ' from the system?', 'escape' => false, 'style' => 'color: var(--accent-red); font-size: 16px;', 'title' => 'Delete']
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>