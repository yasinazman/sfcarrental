<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
$this->Html->css('admin-cars', ['block' => true]); // Panggil fail CSS baharu
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

<div class="cars-toolbar">
    
    <div class="category-filter-bar cars-filter-bar">
        <?php 
        $categories = ['Economy', 'Compact', 'Sedan', 'MPV', 'SUV']; 
        $currentCategory = $this->request->getQuery('category');
        ?>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="badge-status <?= empty($currentCategory) ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">All Cars</a>
        <?php foreach($categories as $cat): ?>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['category' => $cat]]) ?>" class="badge-status <?= $currentCategory == $cat ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;"><?= $cat ?></a>
        <?php endforeach; ?>
    </div>

    <div class="cars-search-group">
        <form method="get" action="<?= $this->Url->build(['action' => 'index']) ?>" class="cars-search-form">
            <?php if (!empty($currentCategory)): ?>
                <input type="hidden" name="category" value="<?= h($currentCategory) ?>">
            <?php endif; ?>
            <input type="text" name="search" value="<?= h($search ?? '') ?>" placeholder="Search Plate No or Model..." class="form-control search-input">
            <button type="submit" class="btn-search" title="Search"><i class="fas fa-search"></i></button>
            <?php if (!empty($search)): ?>
                <a href="<?= $this->Url->build(['action' => 'index', '?' => ['category' => $currentCategory]]) ?>" class="btn-clear-search" title="Clear Search"><i class="fas fa-times"></i></a>
            <?php endif; ?>
        </form>

        <div class="toolbar-divider"></div>

        <a href="<?= $this->Url->build(['action' => 'export', '?' => $this->request->getQuery()]) ?>" class="btn-export">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>

        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn-add-new">
            <i class="fas fa-plus"></i> Add New Car
        </a>
        
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