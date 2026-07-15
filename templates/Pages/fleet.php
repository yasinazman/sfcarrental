<?php
/**
 * sfcarrental - Our Fleet Page (Dynamic Database Edition)
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Car> $cars
 * @var string $carType
 */
$this->disableAutoLayout();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sfcarrental | Our Fleet</title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('home') ?>
    <?= $this->Html->css('fleet') ?>

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
                        <option value="luxury" data-en="Luxury & Sports" data-bm="SUV">SUV</option>
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

    <?php $homeUrl = $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'home']); ?>
    <?php $categoriesUrl = $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'categories']); ?>
    <?php $fleetUrl = $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'fleet']); ?>

    <header>
        <div class="navbar">
            <a href="<?= $homeUrl ?>" class="logo">sf<span>carrental</span></a>
            <ul class="nav-links">
                <li><a href="<?= $homeUrl ?>" data-en="Home" data-bm="Utama">Home</a></li>
                <li><a href="<?= $categoriesUrl ?>" data-en="Categories" data-bm="Kategori">Categories</a></li>
                <li><a href="<?= $fleetUrl ?>" class="active-link" data-en="Our Fleet" data-bm="Koleksi Kereta">Our Fleet</a></li>
                <li><a href="<?= $homeUrl ?>#kelebihan" data-en="Why Us" data-bm="Kelebihan">Why Us</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'terms']) ?>" data-en="Terms & Conditions" data-bm="Terma & Syarat">Terms & Conditions</a></li>
                <li><a href="#" id="btn-signin" class="btn-login"><i class="fa-solid fa-user-plus"></i> <span data-en="Sign In / Register" data-bm="Log Masuk / Daftar">Sign In / Register</span></a></li>
            </ul>
        </div>
    </header>

    <section class="fleet-page-hero">
        <h1 data-en="Our International Standard Fleet" data-bm="Pilihan Kereta Standard Antarabangsa">Our International Standard Fleet</h1>
        <p data-en="Clean, reliable, and ready for your next Malaysian adventure." data-bm="Bersih, boleh dipercayai, dan sedia untuk perjalanan anda.">Clean, reliable, and ready for your next Malaysian adventure.</p>
    </section>

    <div class="content-wrapper-centered">

        <section id="kereta-section" class="fleet-section">

            <div class="fleet-filter-bar">
                <a href="<?= $fleetUrl ?>" class="<?= $carType === 'all' ? 'active' : '' ?>" data-en="All Cars" data-bm="Semua">All Cars</a>
                <a href="<?= $fleetUrl ?>?car_type=economy" class="<?= $carType === 'economy' ? 'active' : '' ?>" data-en="Economy" data-bm="Ekonomi">Economy</a>
                <a href="<?= $fleetUrl ?>?car_type=compact" class="<?= $carType === 'compact' ? 'active' : '' ?>" data-en="Compact" data-bm="Kompak">Compact</a>
                <a href="<?= $fleetUrl ?>?car_type=sedan" class="<?= $carType === 'sedan' ? 'active' : '' ?>" data-en="Sedan" data-bm="Sedan">Sedan</a>
                <a href="<?= $fleetUrl ?>?car_type=mpv" class="<?= $carType === 'mpv' ? 'active' : '' ?>" data-en="MPV" data-bm="MPV">MPV</a>
                <a href="<?= $fleetUrl ?>?car_type=suv" class="<?= $carType === 'suv' ? 'active' : '' ?>" data-en="SUV" data-bm="SUV">SUV</a>
            </div>

            <div class="fleet-grid">
                <?php if (empty($cars) || $cars->isEmpty()): ?>
                    <div style="text-align:center; padding:50px; color:#777; grid-column: 1 / -1;">
                        <i class="fa-solid fa-car-burst fa-3x" style="color:#ddd; margin-bottom:15px;"></i>
                        <h3>Oops! No cars available.</h3>
                        <p>We couldn't find any vehicles in this category at the moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($cars as $car): ?>
                    <div class="car-card">
                        <div class="car-tag"><?= strtoupper(h($car->category ?? 'STD')) ?></div>
                        
                        <?php if (!empty($car->image)): ?>
                            <img src="<?= $this->Url->image('cars/' . $car->image) ?>" alt="<?= h($car->car_model) ?>" class="car-img">
                        <?php else: ?>
                            <div class="car-img" style="background:#f1f1f1; display:flex; align-items:center; justify-content:center; color:#ccc;"><i class="fa-solid fa-car fa-3x"></i></div>
                        <?php endif; ?>

                        <div class="car-info">
                            <div class="car-name"><?= h($car->car_model) ?> </div>
                            <div class="price-box">
                                <span class="currency">MYR</span> <span class="amount"><?= $this->Number->format($car->daily_rate, ['places' => 0]) ?></span> <span class="per-day">/day</span>
                            </div>
                            <div class="car-specs">
                                <span><i class="fa-solid fa-user"></i> <span data-en="<?= h($car->seat_capacity ?? 5) ?> Seats" data-bm="<?= h($car->seat_capacity ?? 5) ?> Tempat"><?= h($car->seat_capacity ?? 5) ?> Seats</span></span>
                                <span><i class="fa-solid fa-gear"></i> <?= h($car->transmission ?? 'Auto') ?></span>
                                <span><i class="fa-solid fa-suitcase"></i> <?= h($car->baggage_capacity ?? 2) ?> Bags</span>
                            </div>
                            <div class="car-extra-details">
                                <div class="detail-item"><i class="fa-solid fa-gas-pump"></i> <span>Fuel:</span> <?= h($car->fuel_type ?? 'Petrol') ?></div>
                                <div class="detail-item"><i class="fa-solid fa-circle-dot"></i> <span data-en="Spare Tyre:" data-bm="Tayar Ganti:">Spare Tyre:</span> <span><?= h($car->spare_tyre ?? 'Yes') ?></span></div>
                                <div class="detail-item"><i class="fa-solid fa-baby-carriage"></i> <span>Child Seat:</span> ISOFIX</div>
                                <div class="detail-item"><i class="fa-solid fa-wrench"></i> <span>Specs:</span> <?= h($car->special_specs ?? $car->engine_capacity) ?> </div>
                            </div>
                            
                            <?php if ($car->availability_status === 'Available'): ?>
                                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" class="btn-lock"><i class="fa-solid fa-calendar-check"></i> <span data-en="Book Now & Pay Later" data-bm="Tempah & Bayar Kemudian">Book Now & Pay Later</span></a>
                            <?php else: ?>
                                <a href="#" class="btn-lock" style="background:#ccc; cursor:not-allowed; border-color:#ccc;" onclick="return false;"><i class="fa-solid fa-clock"></i> <span data-en="Currently Unavailable" data-bm="Sedang Digunakan">Currently Unavailable</span></a>
                            <?php endif; ?>
                            
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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

        signinOverlay.addEventListener('click', (e) => {
            if (e.target === signinOverlay) {
                signinOverlay.classList.remove('active');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                signinOverlay.classList.remove('active');
            }
        });

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
    </script>
</body>
</html>