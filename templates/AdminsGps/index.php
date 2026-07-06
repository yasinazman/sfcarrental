<?php 
$this->assign('title', $pageTitle); 
// Pautkan fail CSS baru
$this->Html->css('admin-gps', ['block' => true]); 
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="content-header" style="margin-bottom: 24px;">
    <h3 style="margin: 0; font-size: 20px; color: var(--text-main);">Monitor the real-time location of your active fleet.</h3>
</div>

<div style="background: #fff; padding: 10px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 30px;">
    <div id="map" style="height: 500px; width: 100%; border-radius: 8px; z-index: 1;"></div>
</div>

<div class="recent-activity">
    <div class="table-title-area" style="padding: 20px 24px; border-bottom: 1px solid #eee;">
        <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: var(--text-main);">Active Fleet Locations</h3>
    </div>
    <table class="dashboard-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 16px 24px; text-align: left; background: #fdfdfd; color: var(--text-light); font-weight: 500; font-size: 14px; border-bottom: 1px solid #eee;">Car Details</th>
                <th style="padding: 16px 24px; text-align: left; background: #fdfdfd; color: var(--text-light); font-weight: 500; font-size: 14px; border-bottom: 1px solid #eee;">Status</th>
                <th style="padding: 16px 24px; text-align: left; background: #fdfdfd; color: var(--text-light); font-weight: 500; font-size: 14px; border-bottom: 1px solid #eee;">GPS Coordinates</th>
                <th style="padding: 16px 24px; text-align: center; background: #fdfdfd; color: var(--text-light); font-weight: 500; font-size: 14px; border-bottom: 1px solid #eee;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($cars->isEmpty()): ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-light);">No active GPS signals found.</td>
            </tr>
            <?php else: ?>
                <?php foreach ($cars as $car): ?>
                <tr>
                    <td style="padding: 16px 24px; border-bottom: 1px solid #eee;">
                        <span style="font-weight: 600; color: var(--text-main);"><?= h($car->car_model) ?></span><br>
                        <span style="font-size: 12px; color: #007bff; font-weight: 600;"><?= h($car->plate_number) ?></span>
                    </td>
                    <td style="padding: 16px 24px; border-bottom: 1px solid #eee;">
                        <?php
                            $status = strtolower($car->availability_status);
                            $badgeClass = 'badge-grey';
                            if ($status == 'available') { $badgeClass = 'badge-green'; }
                            elseif ($status == 'rented') { $badgeClass = 'badge-yellow'; }
                            elseif ($status == 'maintenance') { $badgeClass = 'badge-red'; }
                        ?>
                        <span class="badge-status <?= $badgeClass ?>" style="padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; display: inline-block;">
                            <?= h($car->availability_status) ?>
                        </span>
                    </td>
                    <td style="padding: 16px 24px; border-bottom: 1px solid #eee; font-family: monospace; color: #666;">
                        <?= h($car->latitude) ?>, <?= h($car->longitude) ?>
                    </td>
                    <td style="padding: 16px 24px; border-bottom: 1px solid #eee; text-align: center;">
                        <button onclick="focusOnCar(<?= h($car->latitude) ?>, <?= h($car->longitude) ?>)" class="btn-track" title="Locate on Map">
                            <i class="fas fa-crosshairs"></i> Locate
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    // Jadikan data PHP sebagai variable global supaya file JS luar boleh baca
    window.fleetData = <?= json_encode($cars) ?>;
</script>

<?php 
// Pautkan fail JS baru (diletakkan di bawah sekali)
$this->Html->script('admin-gps', ['block' => true]); 
?>