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

    /* Padding untuk grid supaya tidak melekat pada hujung skrin */
    .content-wrapper {
        padding: 40px !important;
        width: 100% !important;
        box-sizing: border-box;
    }

    /* ========================================================
       REKA BENTUK KAD KERETA (Seiras dengan halaman Fleet)
       ======================================================== */
    .fleet-card {
        background: #1e232d; /* Warna biru gelap/kelabu seperti dalam gambar */
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

    .car-image-container {
        position: relative;
        background: #ffffff; /* Latar putih supaya gambar kereta nampak jelas */
        padding: 20px;
        text-align: center;
        border-bottom: 3px solid #1a1e27;
    }

    .car-image-container img {
        width: 100%;
        height: 200px;
        object-fit: contain;
    }

    /* Tag Kategori & Nombor Plat */
    .tag-container {
        position: absolute;
        top: 15px;
        left: 15px;
        right: 15px;
        display: flex;
        justify-content: space-between;
    }

    .category-tag {
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .plate-tag {
        background: #fdc500; /* Warna kuning ala-ala nombor plat Malaysia */
        color: #000;
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .car-info {
        padding: 25px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .car-model-title {
        color: #ffffff;
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        margin: 0 0 15px 0;
    }

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
                
                <!-- Gambar Kereta, Kategori & Nombor Plat -->
                <div class="car-image-container">
                    <div class="tag-container">
                        <span class="category-tag"><?= h($car->category ?? 'STANDARD') ?></span>
                        <span class="plate-tag"><?= h($car->plate_number ?? 'N/A') ?></span>
                    </div>
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
                    <h3 class="car-model-title"><?= h($car->car_model) ?></h3>
                    
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
                    
                    <!-- Butang Pilih Kereta (Menghantar data carian ke borang tempahan) -->
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
                        'escape' => false, // Penting supaya ikon FontAwesome dirender sebagai HTML
                        'class' => 'btn-select-car'
                    ]) ?>
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