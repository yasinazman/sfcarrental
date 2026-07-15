<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
?>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<div class="maintenance-stats-grid">
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;"><i class="fas fa-wrench"></i></div>
        <div class="m-stat-info">
            <h4>Total Maintenance Cost</h4>
            <p class="val">RM <?= $this->Number->format($totalCost, ['places' => 2]) ?></p>
        </div>
    </div>
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(23, 162, 184, 0.1); color: #17a2b8;"><i class="fas fa-car-crash"></i></div>
        <div class="m-stat-info">
            <h4>Cars In Workshop</h4>
            <p class="val"><?= h($inProgressCount) ?></p>
        </div>
    </div>
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;"><i class="fas fa-calendar-check"></i></div>
        <div class="m-stat-info">
            <h4>Upcoming Services</h4>
            <p class="val"><?= h($scheduledCount) ?></p>
        </div>
    </div>
</div>

<div class="calendar-container">
    <div id="maintenanceCalendar"></div>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px; margin-bottom: 24px; border-bottom: 1px solid #f0f0f0; padding-bottom: 15px;">
    
    <div class="category-filter-bar" style="margin: 0; padding: 0; border: none; display: flex; gap: 10px;">
        <?php 
        $statuses = ['Completed', 'In Progress', 'Scheduled']; 
        $currentStatus = $this->request->getQuery('status');
        ?>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="badge-status <?= empty($currentStatus) ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">All Records</a>
        
        <?php foreach($statuses as $stat): ?>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => $stat]]) ?>" class="badge-status <?= $currentStatus == $stat ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;"><?= $stat ?></a>
        <?php endforeach; ?>
    </div>

    <div style="display: flex; gap: 12px; align-items: center;">
        <a href="<?= $this->Url->build(['action' => 'export', '?' => $this->request->getQuery()]) ?>" style="padding: 10px 20px; border-radius: 6px; background: #28a745; color: white; text-decoration: none; font-weight: 500; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s ease;" onmouseover="this.style.background='#218838';" onmouseout="this.style.background='#28a745';">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>

        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn-add-new" style="margin: 0; background: var(--accent-red); color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 500; font-size: 14px; box-shadow: 0 4px 6px rgba(220, 53, 69, 0.2);">
            <i class="fas fa-plus"></i> Add New Record
        </a>
    </div>
    
</div>

<div class="dashboard-box">
    <table class="dashboard-table" style="width: 100%;">
        <thead>
            <tr>
                <th>Car Details</th>
                <th>Service Type</th>
                <th>Cost</th>
                <th>Mileage</th>
                <th>Service Date</th>
                <th>Status</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($maintenances->isEmpty()): ?>
            <tr>
                <td colspan="7" class="no-data-text" style="text-align: center; padding: 30px;">No maintenance records found.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($maintenances as $record): ?>
                <tr>
                    <td>
                        <span class="name-cell"><?= h($record->car->car_model ?? 'Unknown') ?></span><br>
                        <span class="plate-text" style="font-size: 12px; color: #007bff; font-weight: 600;"><?= h($record->car->plate_number ?? '') ?></span>
                    </td>
                    <td style="font-weight: 500; color: var(--text-main);"><?= h($record->service_type) ?></td>
                    <td class="id-cell">RM <?= $this->Number->format($record->cost, ['places' => 2]) ?></td>
                    <td><?= $record->mileage ? number_format($record->mileage) . ' km' : '<span style="color:#aaa;">-</span>' ?></td>
                    <td><?= h($record->service_date->format('d M Y')) ?></td>
                    <td>
                        <?php
                            $status = strtolower($record->status);
                            $badgeClass = 'badge-grey';
                            if (strpos($status, 'scheduled') !== false) { $badgeClass = 'badge-yellow'; }
                            elseif (strpos($status, 'completed') !== false) { $badgeClass = 'badge-green'; }
                            elseif (strpos($status, 'in progress') !== false) { $badgeClass = 'badge-blue'; }
                        ?>
                        <span class="badge-status <?= $badgeClass ?>"><?= h($record->status) ?></span>
                    </td>
                    <td class="action-cell">
                        <div class="action-cell-wrap">
                            <a href="<?= $this->Url->build(['action' => 'view', $record->id]) ?>" style="color: #17a2b8; margin-right: 15px; font-size: 16px;" title="View Details"><i class="fas fa-eye"></i></a>
                            <a href="<?= $this->Url->build(['action' => 'edit', $record->id]) ?>" style="color: #007bff; margin-right: 15px; font-size: 16px;" title="Edit Record"><i class="fas fa-edit"></i></a>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $record->id],
                                ['confirm' => 'Delete this record?', 'escape' => false, 'style' => 'color: var(--accent-red); font-size: 16px;', 'title' => 'Delete']
                            ) ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    window.maintenanceEvents = <?= json_encode($calendarEvents) ?>;
</script>

<?php $this->Html->script('admin-maintenances', ['block' => true]); ?>