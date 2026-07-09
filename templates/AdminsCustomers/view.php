<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-dashboard', ['block' => true]); 
$this->Html->css('admin-customers', ['block' => true]); 
?>

<div class="content-header profile-header-flex">
    <div>
        <h3 class="profile-name"><?= h($customer->full_name) ?></h3>
        <p class="profile-meta">
            <i class="fas fa-phone-alt"></i> <?= h($customer->phone_number) ?> &nbsp;|&nbsp; 
            Joined: <?= h($customer->created->format('d M Y')) ?>
        </p>
    </div>
    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn-cancel btn-back"><i class="fas fa-arrow-left"></i> Back to Database</a>
</div>

<div class="profile-stats-grid">
    <div class="m-stat-card <?= $customer->account_status === 'Blacklisted' ? 'border-red' : 'border-green' ?>">
        <div class="m-stat-info">
            <h4 class="stat-title">Account Status</h4>
            <?php $accStatusClass = ($customer->account_status === 'Blacklisted') ? 'badge-red' : 'badge-green'; ?>
            <span class="badge-status <?= $accStatusClass ?>"><?= h($customer->account_status) ?></span>
        </div>
    </div>
    
    <div class="m-stat-card">
        <div class="m-stat-info">
            <h4>Lifetime Value (Spent)</h4>
            <p class="val val-blue">RM <?= $this->Number->format($totalSpent, ['places' => 2]) ?></p>
        </div>
    </div>
    
    <div class="m-stat-card">
        <div class="m-stat-info">
            <h4>Completed Trips</h4>
            <p class="val"><?= h($completedTrips) ?></p>
        </div>
    </div>
</div>

<div class="profile-content-grid">
    <div>
        <div class="dashboard-box document-box">
            <h4 class="document-box-title"><i class="fas fa-file-alt"></i> Verification Documents</h4>
            
            <!-- Kad Pengenalan (Depan & Belakang) -->
            <div class="document-item">
                <span class="document-label">Identity Card (IC)</span>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <!-- IC Depan -->
                    <div>
                        <span style="font-size: 11px; color: #888; font-weight: 600; display: block; margin-bottom: 6px;">FRONT</span>
                        <?php if (!empty($customer->ic_file_path)): ?>
                            <a href="<?= $this->Url->image('customers/' . $customer->ic_file_path) ?>" target="_blank">
                                <img src="<?= $this->Url->image('customers/' . $customer->ic_file_path) ?>" class="document-img" alt="IC Front">
                            </a>
                        <?php else: ?>
                            <div class="document-missing" style="padding: 20px 10px;">
                                <i class="fas fa-times-circle" style="font-size: 20px; margin-bottom: 8px;"></i><br>
                                <span style="font-size: 11px;">No Front Uploaded</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- IC Belakang -->
                    <div>
                        <span style="font-size: 11px; color: #888; font-weight: 600; display: block; margin-bottom: 6px;">BACK</span>
                        <?php if (!empty($customer->ic_back_file_path)): ?>
                            <a href="<?= $this->Url->image('customers/' . $customer->ic_back_file_path) ?>" target="_blank">
                                <img src="<?= $this->Url->image('customers/' . $customer->ic_back_file_path) ?>" class="document-img" alt="IC Back">
                            </a>
                        <?php else: ?>
                            <div class="document-missing" style="padding: 20px 10px;">
                                <i class="fas fa-times-circle" style="font-size: 20px; margin-bottom: 8px;"></i><br>
                                <span style="font-size: 11px;">No Back Uploaded</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div>
                <span class="document-label">Driving License</span>
                <?php if (!empty($customer->license_file_path)): ?>
                    <a href="<?= $this->Url->image('customers/' . $customer->license_file_path) ?>" target="_blank">
                        <img src="<?= $this->Url->image('customers/' . $customer->license_file_path) ?>" class="document-img" alt="License Document">
                    </a>
                <?php else: ?>
                    <div class="document-missing">
                        <i class="fas fa-times-circle"></i>
                        No License Uploaded
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div>
        <div class="dashboard-box history-box">
            <div class="history-header">
                <h4><i class="fas fa-history"></i> Booking History (<?= count($bookings) ?>)</h4>
            </div>
            
            <table class="dashboard-table history-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Car Details</th>
                        <th>Rental Period</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($bookings->isEmpty()): ?>
                    <tr>
                        <td colspan="5" class="no-data-text" style="text-align: center; padding: 40px;">This customer hasn't made any bookings yet.</td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td class="price-bold">
                                <a href="<?= $this->Url->build(['controller' => 'AdminsBookings', 'action' => 'view', $booking->id]) ?>" class="link-blue">#<?= h($booking->id) ?></a>
                            </td>
                            <td>
                                <span class="car-name-bold"><?= h($booking->car->car_model ?? 'Unknown') ?></span><br>
                                <span class="car-plate-small"><?= h($booking->car->plate_number ?? '') ?></span>
                            </td>
                            <td>
                                <div class="date-range-text">
                                    <?= h($booking->start_date->format('d M Y')) ?> <i class="fas fa-arrow-right date-arrow"></i> <?= h($booking->end_date->format('d M Y')) ?>
                                </div>
                            </td>
                            <td class="price-bold">RM <?= $this->Number->format($booking->total_price, ['places' => 2]) ?></td>
                            <td>
                                <?php
                                    $status = strtolower($booking->booking_status);
                                    $badgeClass = 'badge-grey';
                                    if (strpos($status, 'pending') !== false) { $badgeClass = 'badge-yellow'; }
                                    elseif (strpos($status, 'approved') !== false || strpos($status, 'active') !== false) { $badgeClass = 'badge-green'; }
                                    elseif (strpos($status, 'completed') !== false) { $badgeClass = 'badge-blue'; }
                                    elseif (strpos($status, 'cancelled') !== false) { $badgeClass = 'badge-red'; }
                                ?>
                                <span class="badge-status <?= $badgeClass ?>"><?= h($booking->booking_status) ?></span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>