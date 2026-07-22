<?php
/**
 * sfcarrental - Categories Page
 * @var \App\View\AppView $this
 */
// KOD $this->disableAutoLayout(); TELAH DIPADAM SUPAYA IA GUNA DEFAULT LAYOUT
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sfcarrental | Browse by Category</title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('home') ?>
    <?= $this->Html->css('categories') ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

<!-- ==============================================
     KANDUNGAN UNIK HALAMAN KATEGORI BERMULA DI SINI
     ============================================== -->

<div class="booking-form-container">
    <h3 class="booking-form-title" data-en="Booking Form" data-bm="Borang Tempahan">Booking Form</h3>
    <form action="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'fleet']) ?>" method="GET" class="booking-form">
        <div class="form-grid">
            <div class="form-group">
                <label><i class="fa-solid fa-map-location-dot"></i> <span data-en="Where are you heading to?" data-bm="Lokasi Destinasi">Where are you heading to?</span></label>
                <input type="text" name="destination" placeholder="e.g., Genting Highlands..." data-en-placeholder="e.g., Genting Highlands, Melaka..." data-bm-placeholder="e.g., Genting Highlands, Melaka..." required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-car-side"></i> <span data-en="Vehicle Class" data-bm="Jenis Kereta">Vehicle Class</span></label>
                <select name="car_type">
                    <option value="all" data-en="All Vehicle Classes" data-bm="Semua Jenis Kereta">All Vehicle Classes</option>
                    <option value="ekonomi" data-en="Budget / Economy" data-bm="Ekonomi">Economy</option>
                    <option value="sedan" data-en="Standard Sedan" data-bm="Kompak">Compact</option>
                    <option value="suv" data-en="SUV / Crossover" data-bm="Sedan">Sedan</option>
                    <option value="mpv" data-en="Family MPV (7-Seater)" data-bm="MPV">MPV</option>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-location-dot"></i> <span data-en="Pick-up Location" data-bm="Lokasi Ambil">Pick-up Location</span></label>
                <select name="pickup_location" required>
                    <option value="" data-en="Select Location..." data-bm="Pilih Lokasi...">Select Location...</option>
                    <option value="SF HQ">SF Car Rental HQ</option>
                    <option value="I-CITY">I-City Shah Alam</option>
                    <option value="AEON">AEON Mall Shah Alam</option>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-calendar-plus"></i> <span data-en="Pick-up Date & Time" data-bm="Tarikh & Masa Ambil">Pick-up Date & Time</span></label>
                <input type="datetime-local" name="pickup_date" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-calendar-minus"></i> <span data-en="Return Date & Time" data-bm="Tarikh & Masa Pulang">Return Date & Time</span></label>
                <input type="datetime-local" name="return_date" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-location-dot"></i> <span data-en="Drop-off Location" data-bm="Lokasi Pulang">Drop-off Location</span></label>
                <select name="dropoff_location" required>
                    <option value="" data-en="Select Location..." data-bm="Pilih Lokasi...">Select Location...</option>
                    <option value="SF HQ">SF Car Rental HQ</option>
                    <option value="I-CITY">I-City Shah Alam</option>
                    <option value="AEON">AEON Mall Shah Alam</option>
                </select>
            </div>

            <div class="form-group btn-container">
                <button type="submit" class="btn-search">
                    <i class="fa-solid fa-magnifying-glass"></i> <span data-en="Search Available Cars" data-bm="Cari Kereta Tersedia">Search Available Cars</span>
                </button>
            </div>
        </div>
    </form>
</div>

<section class="categories-page-hero">
    <h1 data-en="Browse by Vehicle Category" data-bm="Ikut Kategori Pilihan">Browse by Vehicle Category</h1>
    <p data-en="Pick a category below to see cars that match your trip." data-bm="Pilih kategori di bawah untuk lihat kereta yang sesuai dengan perjalanan anda.">Pick a category below to see cars that match your trip.</p>
</section>

<div class="content-wrapper-centered">
    <section id="kategori-section" class="categories-container">
        <div class="categories-grid">
            <div class="category-card active"><span data-en="All Cars" data-bm="Semua">All Cars</span></div>
            <div class="category-card"><span data-en="Economy" data-bm="Ekonomi">Economy</span></div>
            <div class="category-card"><span data-en="Compact" data-bm="Kompak">Compact</span></div>
            <div class="category-card"><span data-en="Sedan" data-bm="Sedan">Sedan</span></div>
            <div class="category-card"><span data-en="MPV" data-bm="MPV">MPV</span></div>
            <div class="category-card"><span data-en="SUV" data-bm="SUV">SUV</span></div>
        </div>

        <?php $fleetUrl = $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'fleet']); ?>
        <div class="categories-big-grid">
            <a href="<?= $fleetUrl ?>?car_type=ekonomi" class="category-big-card">
                <div class="category-icon"><i class="fa-solid fa-car"></i></div>
                <h3 data-en="Economy" data-bm="Ekonomi">Economy</h3>
                <p data-en="Budget-friendly, great on fuel" data-bm="Mesra bajet, jimat minyak">Budget-friendly, great on fuel</p>
            </a>
            <a href="<?= $fleetUrl ?>?car_type=compact" class="category-big-card">
                <div class="category-icon"><i class="fa-solid fa-car-side"></i></div>
                <h3 data-en="Compact" data-bm="Kompak">Compact</h3>
                <p data-en="Easy to drive and park in the city" data-bm="Mudah dipandu & diparkir">Easy to drive and park in the city</p>
            </a>
            <a href="<?= $fleetUrl ?>?car_type=sedan" class="category-big-card">
                <div class="category-icon"><i class="fa-solid fa-car-rear"></i></div>
                <h3 data-en="Sedan" data-bm="Sedan">Sedan</h3>
                <p data-en="Comfortable for longer trips" data-bm="Selesa untuk perjalanan jauh">Comfortable for longer trips</p>
            </a>
            <a href="<?= $fleetUrl ?>?car_type=mpv" class="category-big-card">
                <div class="category-icon"><i class="fa-solid fa-van-shuttle"></i></div>
                <h3 data-en="MPV" data-bm="MPV">MPV</h3>
                <p data-en="7-seater, perfect for families" data-bm="7 tempat duduk, sesuai untuk keluarga">7-seater, perfect for families</p>
            </a>
            <a href="<?= $fleetUrl ?>?car_type=suv" class="category-big-card">
                <div class="category-icon"><i class="fa-solid fa-truck-monster"></i></div>
                <h3 data-en="SUV" data-bm="SUV">SUV</h3>
                <p data-en="Extra space and higher ground clearance" data-bm="Ruang lebih luas & tinggi dari tanah">Extra space and higher ground clearance</p>
            </a>
        </div>
    </section>
</div>

<script>
    // --- JS KHUSUS UNTUK HALAMAN KATEGORI SAHAJA ---
    // (Skrip lain seperti tukar bahasa, dark mode & modal login tidak diperlukan di sini 
    // kerana ia sudah pun berfungsi secara automatik dari fail layout/default.php)
    
    document.querySelectorAll('.categories-grid .category-card').forEach(card => {
        card.addEventListener('click', () => {
            document.querySelectorAll('.categories-grid .category-card').forEach(c => c.classList.remove('active'));
            card.classList.add('active');
        });
    });
</script>