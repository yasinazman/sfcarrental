<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
$this->Html->css('admin-cars', ['block' => true]); 
?>

<div class="maintenance-stats-grid cars-stats-grid">
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(0, 123, 255, 0.1); color: #007bff;"><i class="fas fa-car-side"></i></div>
        <div class="m-stat-info">
            <h4>Total Cars</h4>
            <p class="val"><?= h($totalCars) ?></p>
        </div>
    </div>
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(40, 167, 69, 0.1); color: #28a745;"><i class="fas fa-check-circle"></i></div>
        <div class="m-stat-info">
            <h4>Available</h4>
            <p class="val"><?= h($availableCount) ?></p>
        </div>
    </div>
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(23, 162, 184, 0.1); color: #17a2b8;"><i class="fas fa-key"></i></div>
        <div class="m-stat-info">
            <h4>On Rent</h4>
            <p class="val"><?= h($onRentCount) ?></p>
        </div>
    </div>
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;"><i class="fas fa-tools"></i></div>
        <div class="m-stat-info">
            <h4>In Maintenance</h4>
            <p class="val"><?= h($maintenanceCount) ?></p>
        </div>
    </div>
</div>

<div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 24px; display: flex; flex-direction: column; gap: 15px;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px;">
        
        <div class="category-filter-bar" style="margin: 0; padding: 0;">
            <?php 
            $categories = ['Economy', 'Compact', 'Sedan', 'MPV', 'SUV']; 
            $currentCategory = $this->request->getQuery('category');
            $currentStatus = $this->request->getQuery('status');
            ?>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => $currentStatus]]) ?>" class="badge-status <?= empty($currentCategory) ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">All Categories</a>
            <?php foreach($categories as $cat): ?>
                <a href="<?= $this->Url->build(['action' => 'index', '?' => ['category' => $cat, 'status' => $currentStatus]]) ?>" class="badge-status <?= $currentCategory == $cat ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;"><?= $cat ?></a>
            <?php endforeach; ?>
        </div>

        <div class="category-filter-bar" style="margin: 0; padding: 0;">
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['category' => $currentCategory]]) ?>" class="badge-status <?= empty($currentStatus) ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">All Status</a>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => 'Available', 'category' => $currentCategory]]) ?>" class="badge-status <?= $currentStatus === 'Available' ? 'badge-green' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">Available</a>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => 'On Rent', 'category' => $currentCategory]]) ?>" class="badge-status <?= $currentStatus === 'On Rent' ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">On Rent</a>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => 'Maintenance', 'category' => $currentCategory]]) ?>" class="badge-status <?= $currentStatus === 'Maintenance' ? 'badge-red' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">Maintenance</a>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
        
        <form method="get" action="<?= $this->Url->build(['action' => 'index']) ?>" style="display: flex; gap: 8px; align-items: center; margin: 0;">
            <?php if (!empty($currentCategory)): ?>
                <input type="hidden" name="category" value="<?= h($currentCategory) ?>">
            <?php endif; ?>
            <?php if (!empty($currentStatus)): ?>
                <input type="hidden" name="status" value="<?= h($currentStatus) ?>">
            <?php endif; ?>
            
            <input type="text" name="search" value="<?= h($search ?? '') ?>" placeholder="Search Plate No or Model..." style="width: 280px; padding: 9px 15px; border-radius: 6px; border: 1px solid #ddd; outline: none;">
            <button type="submit" style="padding: 9px 18px; border-radius: 6px; background: #007bff; color: white; border: none; cursor: pointer;"><i class="fas fa-search"></i></button>
            <?php if (!empty($search)): ?>
                <a href="<?= $this->Url->build(['action' => 'index', '?' => ['category' => $currentCategory, 'status' => $currentStatus]]) ?>" style="padding: 9px 15px; text-decoration: none; border-radius: 6px; background: #f8f9fa; border: 1px solid #ddd; color: #dc3545;" title="Clear Search"><i class="fas fa-times"></i></a>
            <?php endif; ?>
        </form>

        <div style="display: flex; gap: 12px; align-items: center;">
            <a href="<?= $this->Url->build(['action' => 'export', '?' => $this->request->getQuery()]) ?>" style="padding: 9px 18px; border-radius: 6px; background: #28a745; color: white; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s;" onmouseover="this.style.background='#218838';" onmouseout="this.style.background='#28a745';">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
            
            <a href="<?= $this->Url->build(['action' => 'add']) ?>" style="padding: 9px 18px; border-radius: 6px; background: var(--accent-red); color: white; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s;" onmouseover="this.style.background='#c82333';" onmouseout="this.style.background='var(--accent-red)';">
                <i class="fas fa-plus"></i> Add New Car
            </a>
        </div>
        
    </div>
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
                <th style="text-align: center; min-width: 180px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($cars->isEmpty()): ?>
            <tr>
                <td colspan="6" class="no-data-text" style="text-align: center; padding: 30px;">
                    <?= !empty($search) ? 'No cars found matching your search.' : 'No cars found in this category.' ?>
                </td>
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
                            $status = $car->availability_status;
                            $badgeClass = 'badge-grey';
                            if ($status === 'Available') $badgeClass = 'badge-green';
                            elseif ($status === 'On Rent') $badgeClass = 'badge-blue';
                            elseif ($status === 'Maintenance') $badgeClass = 'badge-red';
                        ?>
                        <span class="badge-status <?= $badgeClass ?>">
                            <?= h($status) ?>
                        </span>
                    </td>
                    <td class="cars-action-cell">
                        
                        <?php if ($status !== 'Available'): ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-check-circle"></i>',
                                ['action' => 'toggleStatus', $car->id, 'Available'],
                                ['escape' => false, 'class' => 'icon-avail', 'title' => 'Mark as Available', 'confirm' => 'Mark ' . h($car->plate_number) . ' as Available?']
                            ) ?>
                        <?php endif; ?>
                        
                        <?php if ($status !== 'Maintenance'): ?>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-tools"></i>',
                                ['action' => 'toggleStatus', $car->id, 'Maintenance'],
                                ['escape' => false, 'class' => 'icon-maint', 'title' => 'Send to Maintenance', 'confirm' => 'Send ' . h($car->plate_number) . ' to Maintenance?']
                            ) ?>
                        <?php endif; ?>

                        <span class="action-divider">|</span>

                        <a href="<?= $this->Url->build(['action' => 'view', $car->id]) ?>" class="icon-view" title="View Details"><i class="fas fa-eye"></i></a>
                        <a href="<?= $this->Url->build(['action' => 'edit', $car->id]) ?>" class="icon-edit" title="Edit"><i class="fas fa-edit"></i></a>
                        
                        <?= $this->Form->postLink(
                            '<i class="fas fa-trash"></i>',
                            ['action' => 'delete', $car->id],
                            ['confirm' => 'Are you sure you want to delete ' . h($car->car_model) . ' from the system?', 'escape' => false, 'class' => 'icon-delete', 'title' => 'Delete']
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>