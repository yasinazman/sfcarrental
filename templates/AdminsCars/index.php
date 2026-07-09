<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
?>

<div class="content-header box-header">
    <div>
        <h3 class="box-title" style="font-size: 22px;">Car Fleet</h3>
        <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">Manage your rental vehicles</p>
    </div>
    <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn-add-new"><i class="fas fa-plus"></i> Add New Car</a>
</div>

<div class="category-filter-bar">
    <?php 
    $categories = ['Economy', 'Compact', 'Sedan', 'MPV', 'SUV']; 
    $currentCategory = $this->request->getQuery('category');
    ?>
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="badge-status <?= empty($currentCategory) ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">All Cars</a>
    
    <?php foreach($categories as $cat): ?>
        <a href="<?= $this->Url->build(['action' => 'index', '?' => ['category' => $cat]]) ?>" class="badge-status <?= $currentCategory == $cat ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;"><?= $cat ?></a>
    <?php endforeach; ?>
</div>

<div class="recent-activity dashboard-box">
    <table class="dashboard-table" style="width: 100%;">
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
                <td colspan="6" class="no-data-text">No cars found in this category.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($cars as $car): ?>
                <tr>
                    <td class="id-cell"><?= h($car->plate_number) ?></td>
                    <td>
                        <div class="car-title-group">
                            <?php if (!empty($car->image)): ?>
                                <img src="<?= $this->Url->image('cars/' . $car->image) ?>" alt="Car" class="car-list-image">
                            <?php else: ?>
                                <div class="car-no-image">No Image</div>
                            <?php endif; ?>
                            <div>
                                <div class="name-cell"><?= h($car->car_model) ?></div>
                                <div style="font-size: 12px; color: var(--text-light);">
                                    <span style="color: #007bff; font-weight: 500;"><?= h($car->category ?: 'Uncategorized') ?></span> • <?= h($car->transmission ?: 'N/A') ?> • <?= h($car->seat_capacity ?: '-') ?> Seats
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><?= h($car->engine_capacity ?: 'N/A') ?></td>
                    <td class="car-rate-text">RM <?= $this->Number->format($car->daily_rate, ['places' => 2]) ?></td>
                    <td>
                        <?php 
                            $badgeClass = $car->availability_status === 'Available' ? 'badge-green' : 'badge-red';
                        ?>
                        <span class="badge-status <?= $badgeClass ?>">
                            <?= h($car->availability_status) ?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <a href="<?= $this->Url->build(['action' => 'view', $car->id]) ?>" style="color: #17a2b8; margin-right: 15px; font-size: 16px;" title="View Details"><i class="fas fa-eye"></i></a>
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