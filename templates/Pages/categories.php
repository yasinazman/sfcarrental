<?php
/**
 * sfcarrental - Categories Page
 * @var \App\View\AppView $this
 */
$this->disableAutoLayout();
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

    <button id="theme-toggle-float" class="theme-btn-float" title="Toggle Dark/Light Mode">
        <i class="fa-solid fa-moon"></i>
    </button>

    <div class="signin-overlay" id="signin-overlay">
        <div class="signin-modal">
            <button class="signin-close" id="signin-close" title="Close"><i class="fa-solid fa-xmark"></i></button>
            <div class="signin-icon"><i class="fa-solid fa-circle-user"></i></div>
            <h3 data-en="Welcome to sfcarrental" data-bm="Selamat Datang ke sfcarrental">Welcome to sfcarrental</h3>
            <p data-en="Please select how you want to continue" data-bm="Sila pilih cara anda mahu teruskan">Please select how you want to continue</p>
            <div class="signin-options">
                <?php
                    // NOTA: tukar controller/action/prefix di bawah ikut route sebenar dalam config/routes.php korang.
                    $userLoginUrl = '#';
                    $adminLoginUrl = '#';
                ?>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" class="btn-option btn-user" style="text-decoration: none;">
                <i class="fa fa-user"></i> 
                <span data-en="Continue as User" data-bm="Teruskan sebagai Pengguna">Continue as User</span>
                </a>
                <a href="<?= h($adminLoginUrl) ?>" class="signin-option-btn admin">
                    <i class="fa-solid fa-user-shield"></i>
                    <span data-en="Continue as Admin" data-bm="Teruskan sebagai Admin">Continue as Admin</span>
                </a>
            </div>
        </div>
    </div>

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

    <div class="top-bar">
        <div class="top-bar-container">
            <div class="top-info">
                <span><i class="fa-solid fa-headset"></i> <span data-en="24/7 Tourist Support: " data-bm="Bantuan Pelancong 24/7: ">24/7 Tourist Support: </span>+6017-244 9251</span>
            </div>
            <div class="top-langs">
                <span id="lang-en" class="lang-btn active">EN</span> | <span id="lang-bm" class="lang-btn">BM</span>
            </div>
        </div>
    </div>

    <header>
        <div class="navbar">
            <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'home']) ?>" class="logo">sf<span>carrental</span></a>
            <ul class="nav-links">
                <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'home']) ?>" data-en="Home" data-bm="Utama">Home</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'categories']) ?>" class="active-link" data-en="Categories" data-bm="Kategori">Categories</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'fleet']) ?>" data-en="Our Fleet" data-bm="Koleksi Kereta">Our Fleet</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'home']) ?>#kelebihan" data-en="Why Us" data-bm="Kelebihan">Why Us</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'terms']) ?>" data-en="Terms & Conditions" data-bm="Terma & Syarat">Terms & Conditions</a></li>
                <li><a href="#" id="btn-signin" class="btn-login"><i class="fa-solid fa-user-plus"></i> <span data-en="Sign In / Register" data-bm="Log Masuk / Daftar">Sign In / Register</span></a></li>
            </ul>
        </div>
    </header>

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

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 sfcarrental Malaysia. All Rights Reserved. Managed by SF Travel & Tours Sdn Bhd.</p>
            <div class="footer-links">
                <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'terms']) ?>" data-en="Terms & Conditions" data-bm="Terma & Syarat">Terms & Conditions</a> |
                <a href="#" data-en="Contact Support" data-bm="Hubungi Bantuan">Contact Support</a>
            </div>
        </div>
    </footer>

    <script>
        // --- LOGIK TUKAR BAHASA EN / BM ---
        const btnEn = document.getElementById('lang-en');
        const btnBm = document.getElementById('lang-bm');

        function toggleLanguage(lang) {
            document.querySelectorAll('[data-en]').forEach(element => {
                if (lang === 'en') {
                    element.innerHTML = element.getAttribute('data-en');
                } else {
                    element.innerHTML = element.getAttribute('data-bm');
                }
            });

            // Kemas kini placeholder untuk input carian destinasi
            const destInput = document.querySelector('input[name="destination"]');
            if (destInput) {
                destInput.placeholder = lang === 'en' ? destInput.getAttribute('data-en-placeholder') : destInput.getAttribute('data-bm-placeholder');
            }
        }

        btnEn.addEventListener('click', () => {
            btnEn.classList.add('active');
            btnBm.classList.remove('active');
            toggleLanguage('en');
        });

        btnBm.addEventListener('click', () => {
            btnBm.classList.add('active');
            btnEn.classList.remove('active');
            toggleLanguage('bm');
        });

        // --- LOGIK FLOATING SIGN IN / REGISTER MODAL ---
        const btnSignIn = document.getElementById('btn-signin');
        const signinOverlay = document.getElementById('signin-overlay');
        const signinClose = document.getElementById('signin-close');

        btnSignIn.addEventListener('click', (e) => {
            e.preventDefault();
            signinOverlay.classList.add('active');
        });

        signinClose.addEventListener('click', () => {
            signinOverlay.classList.remove('active');
        });

        // Tutup modal bila klik kawasan gelap di luar kotak
        signinOverlay.addEventListener('click', (e) => {
            if (e.target === signinOverlay) {
                signinOverlay.classList.remove('active');
            }
        });

        // Tutup modal dengan kekunci Esc
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                signinOverlay.classList.remove('active');
            }
        });

        // --- LOGIK DARK MODE TERAPUNG (FLOATING TOGGLE) ---
        const themeToggleFloat = document.getElementById('theme-toggle-float');

        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-theme');
            themeToggleFloat.innerHTML = '<i class="fa-solid fa-sun"></i>';
        }

        themeToggleFloat.addEventListener('click', () => {
            document.body.classList.toggle('dark-theme');
            let theme = 'light';

            if (document.body.classList.contains('dark-theme')) {
                theme = 'dark';
                themeToggleFloat.innerHTML = '<i class="fa-solid fa-sun"></i>';
            } else {
                themeToggleFloat.innerHTML = '<i class="fa-solid fa-moon"></i>';
            }
            localStorage.setItem('theme', theme);
        });

        // --- KLIK KATEGORI PENDEK (categories-grid) - tandakan active sahaja ---
        document.querySelectorAll('.categories-grid .category-card').forEach(card => {
            card.addEventListener('click', () => {
                document.querySelectorAll('.categories-grid .category-card').forEach(c => c.classList.remove('active'));
                card.classList.add('active');
            });
        });
    </script>
</body>
</html>