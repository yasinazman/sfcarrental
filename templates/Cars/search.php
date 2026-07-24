<?php $this->layout = 'default'; ?>

<!-- Pastikan FontAwesome dimuat turun untuk memaparkan ikon (jika tiada dalam layout default) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
        background-color: #121212; /* Dark theme background */
    }

    /* ========================================================
       REKA BENTUK KAD KERETA
       ======================================================== */
    .fleet-card {
        background: #1e232d; 
        border: 1px solid #2a303c;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .fleet-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }

    /* Bahagian Gambar (Kotak Putih) */
    .car-image-container {
        background: #ffffff; 
        padding: 20px;
        text-align: center;
        border-bottom: 3px solid #1a1e27;
    }

    .car-image-container img {
        width: 100%;
        height: 200px;
        object-fit: contain;
    }

    /* Maklumat di bawah gambar (Kotak Gelap) */
    .car-info {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    /* Tajuk Kereta & Susunan Nombor Plat */
    .car-model-title {
        color: #ffffff;
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        margin: 0 0 10px 0;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px; /* Jarak antara nama kereta dan plat */
    }

    .plate-badge {
        background: #fdc500; /* Warna kuning plat Malaysia */
        color: #000;
        padding: 4px 10px;
        border-radius: 4px;
        font-weight: 800;
        letter-spacing: 1px;
        font-size: 14px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .category-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.1);
        color: #aaa;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 20px;
    }

    /* Harga */
    .price-box {
        text-align: center;
        margin-bottom: 20px;
    }

    .price-box .currency {
        color: #e50914;
        font-weight: bold;
        font-size: 16px;
    }

    .price-box .amount {
        color: #ffffff;
        font-size: 32px;
        font-weight: 800;
        margin: 0 5px;
    }

    .price-box .per-day {
        color: #888;
        font-size: 14px;
    }

    /* Spesifikasi Utama (Tempat duduk, Transmisi, Beg) */
    .car-specs-main {
        display: flex;
        justify-content: space-between;
        border-top: 1px solid #333;
        border-bottom: 1px solid #333;
        padding: 15px 0;
        margin-bottom: 15px;
    }

    .car-specs-main span {
        color: #ccc;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .car-specs-main i {
        color: #e50914;
    }

    /* Spesifikasi Tambahan */
    .car-extra-details {
        background: #181c24;
        border-radius: 8px;
        padding: 15px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 25px;
    }

    .detail-item {
        color: #888;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-item i {
        color: #666;
    }

    /* Butang Tempah */
    .btn-select-car {
        display: block;
        width: 100%;
        background: #e50914;
        color: #ffffff !important;
        text-align: center;
        padding: 15px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
        transition: background 0.2s ease;
        margin-top: auto;
    }

    .btn-select-car:hover {
        background: #b20710;
    }

    /* CSS BARU UNTUK BUTANG DISABLE */
    .btn-disabled {
        display: block;
        width: 100%;
        background: #333333;
        color: #777777 !important;
        text-align: center;
        padding: 15px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        font-size: 16px;
        cursor: not-allowed;
        margin-top: auto;
        pointer-events: none;
    }

    /* Responsif Grid */
    .cars-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    @media (max-width: 1200px) {
        .cars-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .cars-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="full-width-page" style="padding: 40px;">
    <h2 class="section-title" style="color: #fff; margin-bottom: 30px; border-left: 4px solid #e50914; padding-left: 15px;">
        Available Cars for your trip
    </h2>
    
    <div class="cars-grid">
    <?php if (!$cars->isEmpty()): ?>
        <?php foreach ($cars as $car): ?>
            <div class="fleet-card">
                
                <!-- Gambar Kereta Sahaja -->
                <div class="car-image-container">
                    <?php if (!empty($car->image)): ?>
                        <img src="<?= $this->Url->image('cars/' . h($car->image)) ?>" alt="<?= h($car->car_model) ?>">
                    <?php else: ?>
                        <div style="height: 200px; display: flex; align-items: center; justify-content: center; color: #ccc;">
                            <i class="fa-solid fa-car fa-4x"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Maklumat Kereta -->
                <div class="car-info">
                    
                    <!-- Tajuk dan Badge Nombor Plat (Berada dalam aliran standard) -->
                    <h3 class="car-model-title">
                        <?= h($car->car_model) ?>
                        <?php if (!empty($car->plate_number)): ?>
                            <span class="plate-badge"><?= h($car->plate_number) ?></span>
                        <?php endif; ?>
                    </h3>
                    
                    <!-- Kategori Kereta -->
                    <div style="text-align: center;">
                        <span class="category-badge"><?= h($car->category ?? 'STANDARD') ?></span>
                    </div>
                    
                    <div class="price-box">
                        <span class="currency">MYR</span>
                        <span class="amount"><?= $this->Number->format($car->daily_rate, ['places' => 0]) ?></span>
                        <span class="per-day">/day</span>
                    </div>
                    
                    <!-- Spesifikasi Utama (3 Column) -->
                    <div class="car-specs-main">
                        <span><i class="fa-solid fa-user"></i> <?= h($car->seat_capacity ?? 5) ?> Seats</span>
                        <span><i class="fa-solid fa-gear"></i> <?= h($car->transmission ?? 'Auto') ?></span>
                        <span><i class="fa-solid fa-suitcase"></i> <?= h($car->baggage_capacity ?? 2) ?> Bags</span>
                    </div>
                    
                    <!-- Spesifikasi Tambahan (Grid 2x2) -->
                    <div class="car-extra-details">
                        <div class="detail-item">
                            <i class="fa-solid fa-gas-pump"></i> Fuel: <?= h($car->fuel_type ?? 'Petrol') ?>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-circle-dot"></i> Spare Tyre: <?= h($car->spare_tyre ?? 'Yes') ?>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-baby-carriage"></i> Child Seat: ISOFIX
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-wrench"></i> Specs: <?= h($car->special_specs ?? $car->engine_capacity ?? 'Standard') ?>
                        </div>
                    </div>
                    
                    <!-- Butang Pilih Kereta -->
                    <?php 
                    // Semak jika kereta ini ada dalam senarai tempahan bertindih
                    $isBooked = isset($bookedCarIds) && in_array($car->id, $bookedCarIds); 
                    
                    // Semak jika status fizikal kereta sedang diselenggara
                    $isMaintenance = (strtolower($car->availability_status ?? '') === 'maintenance');
                    ?>

                    <?php if ($isMaintenance): ?>
                        <a href="javascript:void(0);" class="btn-disabled" title="This car is currently under maintenance">
                            <i class="fa-solid fa-wrench" style="margin-right: 8px;"></i> Under Maintenance
                        </a>
                    <?php elseif ($isBooked): ?>
                        <a href="javascript:void(0);" class="btn-disabled" title="This car is already booked for the selected dates">
                            <i class="fa-solid fa-ban" style="margin-right: 8px;"></i> Not Available
                        </a>
                    <?php else: ?>
                        <?= $this->Html->link('<i class="fa-regular fa-calendar-check" style="margin-right: 8px;"></i> Select This Car', [
                            'controller' => 'Bookings',
                            'action' => 'add',
                            $car->id,
                            '?' => [
                                'start_date' => $this->request->getQuery('pickup_date') ?? $this->request->getQuery('start_date'),
                                'end_date' => $this->request->getQuery('return_date') ?? $this->request->getQuery('end_date'),
                                'destination' => $this->request->getQuery('destination'),
                                'pickup_location' => $this->request->getQuery('pickup_location'),
                                'dropoff_location' => $this->request->getQuery('dropoff_location')
                            ]
                        ], [
                            'escape' => false,
                            'class' => 'btn-select-car'
                        ]) ?>
                    <?php endif; ?>
                </div>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #1e1e1e; border-radius: 12px; border: 1px solid #333;">
            <i class="fa-solid fa-car-burst fa-3x" style="color: #666; margin-bottom: 20px;"></i>
            <h3 style="color: #fff;">No cars available.</h3>
            <p style="color: #aaa;">We couldn't find any vehicles matching your search criteria. Please try different dates or categories.</p>
        </div>
    <?php endif; ?>
    </div>
</div>