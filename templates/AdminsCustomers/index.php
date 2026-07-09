<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
?>

<div class="maintenance-stats-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 24px;">
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(0, 123, 255, 0.1); color: #007bff;"><i class="fas fa-users"></i></div>
        <div class="m-stat-info">
            <h4>Total Registered</h4>
            <p class="val"><?= number_format($totalCustomers) ?></p>
        </div>
    </div>
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;"><i class="fas fa-id-card-alt"></i></div>
        <div class="m-stat-info">
            <h4>Pending Verification</h4>
            <p class="val"><?= number_format($pendingCount) ?></p>
        </div>
    </div>
    <div class="m-stat-card">
        <div class="m-stat-icon" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;"><i class="fas fa-user-slash"></i></div>
        <div class="m-stat-info">
            <h4>Blacklisted Accounts</h4>
            <p class="val"><?= number_format($blacklistedCount) ?></p>
        </div>
    </div>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
    <div class="category-filter-bar" style="margin: 0; padding: 0;">
        <?php $currentFilter = $this->request->getQuery('status'); ?>
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="badge-status <?= empty($currentFilter) ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">All Customers</a>
        <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => 'Pending Verification']]) ?>" class="badge-status <?= $currentFilter === 'Pending Verification' ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">Pending Verification</a>
        <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => 'Blacklisted']]) ?>" class="badge-status <?= $currentFilter === 'Blacklisted' ? 'badge-blue' : 'badge-grey' ?>" style="text-decoration: none; padding: 8px 16px;">Blacklisted</a>
    </div>

    <div style="display: flex; gap: 15px; align-items: center;">
        <form method="get" action="<?= $this->Url->build(['action' => 'index']) ?>" style="display: flex; gap: 8px; align-items: center; margin: 0;">
            <?php if (!empty($currentFilter)): ?>
                <input type="hidden" name="status" value="<?= h($currentFilter) ?>">
            <?php endif; ?>
            <input type="text" name="search" value="<?= h($search ?? '') ?>" placeholder="Search name or phone..." class="form-control" style="width: 250px; padding: 8px 12px; border-radius: 6px; border: 1px solid #ccc;">
            <button type="submit" style="padding: 8px 15px; border-radius: 6px; background: #007bff; color: white; border: none; cursor: pointer; transition: 0.2s;"><i class="fas fa-search"></i></button>
            <?php if (!empty($search)): ?>
                <a href="<?= $this->Url->build(['action' => 'index', '?' => ['status' => $currentFilter]]) ?>" style="padding: 8px 15px; text-decoration: none; border-radius: 6px; background: #f8f9fa; border: 1px solid #ccc; color: #dc3545;"><i class="fas fa-times"></i></a>
            <?php endif; ?>
        </form>

        <div style="width: 1px; height: 30px; background: #ddd;"></div>

        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn-submit" style="background: var(--accent-red); color: white; padding: 8px 15px; border-radius: 6px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s ease, transform 0.2s ease;" onmouseover="this.style.background='#c82333'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='var(--accent-red)'; this.style.transform='translateY(0)';">
            <i class="fas fa-user-plus"></i> Add Customer
        </a>
    </div>
</div>

<div class="dashboard-box">
    <table class="dashboard-table" style="width: 100%;">
        <thead>
            <tr>
                <th>Customer Info</th>
                <th>Contact</th>
                <th>Documents</th>
                <th style="text-align: center;">Total Bookings</th>
                <th>Account Status</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($customers->isEmpty()): ?>
            <tr>
                <td colspan="6" class="no-data-text" style="text-align: center; padding: 30px;">No customers found.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td>
                        <div style="font-weight: 600; color: var(--text-main); font-size: 15px;"><?= h($customer->full_name) ?></div>
                        <div style="font-size: 12px; color: var(--text-light);">Joined <?= h($customer->created->format('d M Y')) ?></div>
                    </td>
                    <td>
                        <span style="font-weight: 500; color: #007bff;"><i class="fas fa-phone-alt" style="font-size: 11px; margin-right: 5px;"></i><?= h($customer->phone_number) ?></span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            <?php if (!empty($customer->ic_file_path)): ?>
                                <a href="<?= $this->Url->image('customers/' . $customer->ic_file_path) ?>" target="_blank" class="badge-status badge-green" style="text-decoration: none; font-size: 11px;" title="View IC"><i class="fas fa-check-circle"></i> IC</a>
                            <?php else: ?>
                                <span class="badge-status badge-red" style="font-size: 11px;" title="Missing IC"><i class="fas fa-times-circle"></i> IC</span>
                            <?php endif; ?>

                            <?php if (!empty($customer->license_file_path)): ?>
                                <a href="<?= $this->Url->image('customers/' . $customer->license_file_path) ?>" target="_blank" class="badge-status badge-green" style="text-decoration: none; font-size: 11px;" title="View License"><i class="fas fa-check-circle"></i> License</a>
                            <?php else: ?>
                                <span class="badge-status badge-red" style="font-size: 11px;" title="Missing License"><i class="fas fa-times-circle"></i> License</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td style="text-align: center; font-weight: bold; font-size: 16px;">
                        <?= $customerBookings[$customer->id] ?? 0 ?>
                    </td>
                    <td>
                        <?php $accStatusClass = ($customer->account_status === 'Blacklisted') ? 'badge-red' : 'badge-green'; ?>
                        <span class="badge-status <?= $accStatusClass ?>"><?= h($customer->account_status) ?></span>
                    </td>
                    <td style="text-align: center; display: flex; justify-content: center; align-items: center; gap: 15px;">
                        
                        <?= $this->Form->postLink(
                            $customer->account_status === 'Blacklisted' ? '<i class="fas fa-unlock"></i>' : '<i class="fas fa-ban"></i>',
                            ['action' => 'toggleStatus', $customer->id],
                            [
                                'escape' => false, 
                                'style' => 'color: ' . ($customer->account_status === 'Blacklisted' ? '#28a745' : '#dc3545') . '; font-size: 16px;', 
                                'title' => $customer->account_status === 'Blacklisted' ? 'Reactivate Account' : 'Blacklist Customer',
                                'confirm' => 'Are you sure you want to change this customer\'s status?'
                            ]
                        ) ?>

                        <span style="color: #ccc;">|</span>
                        
                        <a href="<?= $this->Url->build(['action' => 'view', $customer->id]) ?>" style="color: #17a2b8; font-size: 16px;" title="View Full Profile"><i class="fas fa-eye"></i></a>
                        
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>