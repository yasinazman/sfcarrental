<?php $this->layout = 'default'; ?>

<style>
    /* Reset semua container supaya ambil lebar skrin penuh */
    .container, .container-fluid, .main-wrapper, .wrapper {
        max-width: 100% !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* Paksa body dan html supaya tiada margin */
    body, html {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow-x: hidden;
    }

    /* Padding untuk grid supaya tidak melekat pada hujung skrin */
    .content-wrapper {
        padding: 40px !important;
        width: 100% !important;
        box-sizing: border-box;
    }
</style>

<div class="full-width-page" style="padding: 40px;">
    <h2 class="section-title" style="color: #fff; margin-bottom: 30px;">Available Cars for your trip</h2>
    
    <!-- Senarai Kereta (Grid) -->
    <div class="cars-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px;">
    <?php if (!$cars->isEmpty()): ?>
        <?php foreach ($cars as $car): ?>
            <div class="car-card" style="background: #1e1e1e; border: 1px solid #333; padding: 20px; border-radius: 12px; transition: 0.3s;">
                <!-- Gambar Kereta -->
                <img src="<?= $this->Url->webroot('img/cars/' . h($car->image)) ?>" 
                     alt="<?= h($car->car_model) ?>" 
                     style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
                
                <!-- Info Kereta -->
                <h3 style="color: #fff; margin: 10px 0;"><?= h($car->car_model) ?></h3> 
                <p style="color: #aaa; margin-bottom: 20px;">Harga: RM <?= number_format((float)$car->daily_rate, 2) ?> / hari</p>
                
                <!-- Butang Select -->
                <?= $this->Html->link('Select This Car', [
                    'controller' => 'Bookings', 
                    'action' => 'add', 
                    $car->id,
                    '?' => [ // Bawa SEMUA data carian ke halaman Booking
                        'start_date' => $this->request->getQuery('pickup_date') ?? $this->request->getQuery('start_date'),
                        'end_date' => $this->request->getQuery('return_date') ?? $this->request->getQuery('end_date'),
                        'destination' => $this->request->getQuery('destination'),
                        'pickup_location' => $this->request->getQuery('pickup_location'),
                        'dropoff_location' => $this->request->getQuery('dropoff_location')
                    ]
                ], [
                    'style' => 'display: block; text-align: center; background: #e50914; color: white; padding: 12px; border-radius: 6px; text-decoration: none; font-weight: bold;'
                ]) ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: #fff; font-size: 18px;">Tiada kereta ditemui untuk carian ini. Sila cuba kategori lain.</p>
    <?php endif; ?>
    </div>
</div>

<style>
    /* CSS Tambahan untuk memastikan layout tidak lari */
    .btn-select:hover {
        background: #b3070f !important;
    }
    
    @media (max-width: 992px) {
        .cars-grid { grid-template-columns: repeat(2, 1fr) !important; }
    }
    
    @media (max-width: 600px) {
        .cars-grid { grid-template-columns: 1fr !important; }
    }
</style>