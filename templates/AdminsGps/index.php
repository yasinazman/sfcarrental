<?php 
$this->assign('title', $pageTitle); 
$this->Html->css('admin-gps', ['block' => true]); 
$this->Html->css('admin-dashboard', ['block' => true]); 
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="content-header" style="margin-bottom: 24px;">
    <h3 style="margin: 0; font-size: 22px; color: var(--text-main);">Fleet Command Center</h3>
    <p style="color: var(--text-light); font-size: 14px; margin: 5px 0 0;">Monitor the real-time location and status of your active fleet.</p>
</div>

<!-- FLEET STATUS DASHBOARD -->
<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-header"><span>Total Cars</span><div class="stat-icon" style="background: rgba(108, 117, 125, 0.1); color: #6c757d;"><i class="fas fa-car"></i></div></div>
        <div class="stat-value" style="color: #333;"><?= h($totalCars) ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-header"><span>Available (At Base)</span><div class="stat-icon icon-green"><i class="fas fa-parking"></i></div></div>
        <div class="stat-value" style="color: #28a745;"><?= h($availableCars) ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-header"><span>On The Move (Rented)</span><div class="stat-icon icon-blue"><i class="fas fa-route"></i></div></div>
        <div class="stat-value" style="color: #007bff;"><?= h($rentedCars) ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-header"><span>In Maintenance</span><div class="stat-icon icon-yellow"><i class="fas fa-tools"></i></div></div>
        <div class="stat-value" style="color: #dcb835;"><?= h($maintenanceCars) ?></div>
    </div>
</div>

<!-- MAP & AUTO REFRESH TOGGLE -->
<div class="gps-map-container">
    <div class="gps-map-header">
        <h4 class="gps-map-title"><i class="fas fa-satellite-dish" style="color: #007bff; margin-right: 8px;"></i> Live Map Radar</h4>
        <label class="live-toggle-label">
            <span id="liveStatusText">Live Tracking: OFF</span>
            <input type="checkbox" id="liveToggle" class="live-toggle-checkbox">
        </label>
    </div>
    <div id="map"></div>
</div>

<!-- FILTER & SEARCH BAR (Updated Categories) -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
        <button class="cat-filter-btn active badge-blue" data-cat="all" style="border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">All Categories</button>
        <button class="cat-filter-btn badge-grey" data-cat="economy" style="border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">Economy</button>
        <button class="cat-filter-btn badge-grey" data-cat="compact" style="border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">Compact</button>
        <button class="cat-filter-btn badge-grey" data-cat="sedan" style="border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">Sedan</button>
        <button class="cat-filter-btn badge-grey" data-cat="mpv" style="border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">MPV</button>
        <button class="cat-filter-btn badge-grey" data-cat="suv" style="border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-weight: 500;">SUV</button>
    </div>
    <div>
        <input type="text" id="gpsSearch" placeholder="Search Plate Number..." style="padding: 9px 15px; border-radius: 6px; border: 1px solid #ddd; width: 250px; outline: none;">
    </div>
</div>

<!-- GPS TABLE (Updated Action Buttons) -->
<div class="recent-activity dashboard-box">
    <div class="table-title-area">
        <h3>Active Fleet Locations</h3>
    </div>
    <table class="dashboard-table" style="width: 100%;">
        <thead>
            <tr>
                <th>Car Details</th>
                <th>Status</th>
                <th>Est. Speed</th>
                <th>GPS Coordinates</th>
                <th>Last Updated</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody id="gpsTableBody">
            <?php if ($cars->isEmpty()): ?>
            <tr>
                <td colspan="6" class="no-data-text" style="text-align: center; padding: 30px;">No active GPS signals found.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($cars as $car): ?>
                <?php $cat = h($car->category ?? 'Unknown'); ?>
                <tr class="gps-row" data-id="<?= $car->id ?>" data-cat="<?= strtolower($cat) ?>" data-plate="<?= h($car->plate_number) ?>">
                    <td class="name-cell">
                        <?= h($car->car_model) ?> <span style="font-size: 11px; color: #888;">(<?= $cat ?>)</span><br>
                        <span style="font-size: 12px; color: #007bff; font-weight: 600;"><?= h($car->plate_number) ?></span>
                    </td>
                    <td>
                        <?php
                            $status = strtolower($car->availability_status);
                            $badgeClass = 'badge-grey';
                            if (strpos($status, 'available') !== false) { $badgeClass = 'badge-green'; }
                            elseif (strpos($status, 'rent') !== false) { $badgeClass = 'badge-red'; }
                            elseif (strpos($status, 'maintenance') !== false) { $badgeClass = 'badge-yellow'; }
                        ?>
                        <span class="badge-status <?= $badgeClass ?>"><?= h($car->availability_status) ?></span>
                    </td>
                    <td style="font-weight: 600; color: #555;" class="gps-speed-<?= $car->id ?>">
                        0 km/h
                    </td>
                    <td style="font-family: monospace; color: #666; font-size: 13px;" class="gps-coord-<?= $car->id ?>">
                        <?= h($car->latitude) ?>, <?= h($car->longitude) ?>
                    </td>
                    <td class="gps-time">
                        <i class="fas fa-circle"></i> Paused
                    </td>
                    <td style="text-align: center; display: flex; justify-content: center; gap: 5px;">
                        
                        <a href="javascript:void(0);" class="btn-action btn-view" title="View Details"
                           data-model="<?= h($car->car_model) ?>"
                           data-plate="<?= h($car->plate_number) ?>"
                           data-status="<?= h($car->availability_status) ?>"
                           data-lat="<?= h($car->latitude) ?>"
                           data-lng="<?= h($car->longitude) ?>">
                            <i class="fas fa-eye"></i> View
                        </a>
                        
                        <button onclick="focusOnCar(<?= $car->id ?>)" class="btn-action btn-locate" title="Locate on Map">
                            <i class="fas fa-crosshairs"></i> Locate
                        </button>
                        
                        <!-- Google Maps Direction Button -->
                        <a href="https://www.google.com/maps/dir/?api=1&destination=<?= h($car->latitude) ?>,<?= h($car->longitude) ?>" target="_blank" class="btn-action btn-direction" title="Get Directions">
                            <i class="fas fa-directions"></i> Direction
                        </a>
                        
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- QUICK VIEW MODAL (Append at the bottom of the file) -->
<div id="gpsViewModal" class="gps-modal-overlay">
    <div class="gps-modal">
        <div class="modal-header">
            <h3 style="margin:0; font-size: 18px; color: var(--text-main);">Car Details</h3>
            <button id="closeGpsModalBtn" class="close-btn">&times;</button>
        </div>
        <div class="modal-body">
            <div class="modal-detail-row">
                <span class="detail-label">Model:</span>
                <span class="detail-value" id="modalCarModel"></span>
            </div>
            <div class="modal-detail-row">
                <span class="detail-label">Plate Number:</span>
                <span class="detail-value" id="modalCarPlate" style="color: #007bff; font-weight: 600;"></span>
            </div>
            <div class="modal-detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value" id="modalCarStatus" style="font-weight: 600;"></span>
            </div>
            <div class="modal-detail-row">
                <span class="detail-label">Coordinates:</span>
                <span class="detail-value" id="modalCarCoords" style="font-family: monospace;"></span>
            </div>
            <div class="modal-detail-row" id="modalBaseIndicator" style="display: none;">
                <span class="detail-label">Location:</span>
                <span class="detail-value" style="color: #28a745; font-size: 12px;">Pusat Komersial Blok E, Seksyen 7</span>
            </div>
        </div>
    </div>
</div>

<script>
    window.fleetData = <?= json_encode($cars) ?>;
</script>

<?php $this->Html->script('admin-gps', ['block' => true]); ?>