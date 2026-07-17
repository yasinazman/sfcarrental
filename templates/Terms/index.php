<?php
/**
 * sfcarrental - Terms & Conditions Page
 * @var \App\View\AppView $this
 */
$this->disableAutoLayout();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sfcarrental | Terms & Conditions</title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('home') ?>
    <?= $this->Html->css('terms') ?>

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
                <a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'login']) ?>" class="btn-option btn-user" style="text-decoration: none;">
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

    <?php
        $homeUrl = $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'home']);
        $categoriesUrl = $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'categories']);
        $fleetUrl = $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'fleet']);
        $termsUrl = $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'terms']);
    ?>

    <header>
        <div class="navbar">
            <a href="<?= $homeUrl ?>" class="logo">sf<span>carrental</span></a>
            <ul class="nav-links">
                <li><a href="<?= $homeUrl ?>" data-en="Home" data-bm="Utama">Home</a></li>
                <li><a href="<?= $categoriesUrl ?>" data-en="Categories" data-bm="Kategori">Categories</a></li>
                <li><a href="<?= $fleetUrl ?>" data-en="Our Fleet" data-bm="Koleksi Kereta">Our Fleet</a></li>
                <li><a href="<?= $homeUrl ?>#kelebihan" data-en="Why Us" data-bm="Kelebihan">Why Us</a></li>
                <li><a href="<?= $termsUrl ?>" class="active-link" data-en="Terms & Conditions" data-bm="Terma & Syarat">Terms & Conditions</a></li>
                <li><a href="#" id="btn-signin" class="btn-login"><i class="fa-solid fa-user-plus"></i> <span data-en="Sign In / Register" data-bm="Log Masuk / Daftar">Sign In / Register</span></a></li>
            </ul>
        </div>
    </header>

    <section class="terms-page-hero">
        <h1 data-en="Terms &amp; Conditions" data-bm="Terma &amp; Syarat">Terms &amp; Conditions</h1>
        <p data-en="Please read these terms carefully before renting a vehicle with us." data-bm="Sila baca terma ini dengan teliti sebelum menyewa kenderaan bersama kami.">Please read these terms carefully before renting a vehicle with us.</p>
    </section>

    <div class="content-wrapper-centered">

        <section class="terms-section-wrap">

            <!-- QUICK JUMP NAV -->
            <nav class="terms-toc">
                <a href="#sec-1">1. Driver Eligibility</a>
                <a href="#sec-2">2. Booking Policy</a>
                <a href="#sec-3">3. Rental Period</a>
                <a href="#sec-4">4. Security Deposit</a>
                <a href="#sec-5">5. Collection &amp; Return</a>
                <a href="#sec-6">6. Interstate Travel</a>
                <a href="#sec-7">7. Fuel Policy</a>
                <a href="#sec-8">8. Mileage Policy</a>
                <a href="#sec-9">9. Vehicle Condition</a>
                <a href="#sec-10">10. Traffic Offences</a>
                <a href="#sec-11">11. Accident Procedure</a>
                <a href="#sec-12">12. Prohibited Use</a>
                <a href="#sec-13">13. Cancellation Policy</a>
                <a href="#sec-14">14. Vehicle Breakdown</a>
                <a href="#sec-15">15. Smoking &amp; Cleanliness</a>
                <a href="#sec-16">16. Lost Items</a>
                <a href="#sec-17">17. Data Privacy</a>
                <a href="#sec-18">18. Governing Law</a>
            </nav>

            <div class="terms-body">

                <div class="terms-card" id="sec-1">
                    <h2><span class="terms-num">1</span> Driver Eligibility</h2>
                    <ul>
                        <li>The renter must be <strong>at least 21 years old</strong>.</li>
                        <li>The renter must possess a <strong>valid Malaysian Driving Licence (Class D)</strong> or an internationally recognized driving licence for foreign customers.</li>
                        <li>Drivers under <strong>25 years old</strong> may be required to pay a <strong>Young Driver Surcharge</strong> of <strong>RM20 per rental</strong>.</li>
                        <li>The renter must present:
                            <ul>
                                <li>Identity Card (MyKad) or Passport</li>
                                <li>Valid Driving Licence</li>
                                <li>Proof of payment (if applicable)</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="terms-card" id="sec-2">
                    <h2><span class="terms-num">2</span> Booking Policy</h2>
                    <ul>
                        <li>Bookings can be made through the company's website, mobile application, WhatsApp, telephone, or walk-in.</li>
                        <li>Reservations are confirmed only after:
                            <ul>
                                <li>Required documents are verified.</li>
                                <li>Deposit/payment is received.</li>
                            </ul>
                        </li>
                        <li>Customers are encouraged to make reservations at least <strong>24 hours before vehicle collection</strong>.</li>
                        <li>Vehicle availability is subject to confirmation.</li>
                    </ul>
                </div>

                <div class="terms-card" id="sec-3">
                    <h2><span class="terms-num">3</span> Rental Period</h2>
                    <p>Rental charges are calculated on a <strong>24-hour basis</strong>. Late returns are subject to additional charges:</p>
                    <div class="table-scroll">
                        <table class="terms-table">
                            <thead>
                                <tr><th>Late Return</th><th>Charge</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Up to 1 hour</td><td>No charge (grace period)</td></tr>
                                <tr><td>1 - 3 hours</td><td>50% of daily rental</td></tr>
                                <tr><td>More than 3 hours</td><td>Full day's rental</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="terms-card" id="sec-4">
                    <h2><span class="terms-num">4</span> Security Deposit</h2>
                    <p>A refundable security deposit is required before vehicle collection.</p>
                    <div class="table-scroll">
                        <table class="terms-table">
                            <thead>
                                <tr><th>Vehicle Category</th><th>Deposit</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Economy</td><td>RM200</td></tr>
                                <tr><td>Compact</td><td>RM300</td></tr>
                                <tr><td>Sedan</td><td>RM300</td></tr>
                                <tr><td>MPV</td><td>RM400</td></tr>
                                <tr><td>SUV</td><td>RM500</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <p>The deposit will be refunded within <strong>7 working days</strong> after the vehicle is returned, subject to inspection.</p>
                </div>

                <div class="terms-card" id="sec-5">
                    <h2><span class="terms-num">5</span> Vehicle Collection &amp; Return</h2>
                    <p>Free vehicle collection and return are available only at:</p>
                    <ul>
                        <li>SF Car Rental HQ</li>
                        <li>i-City Shah Alam</li>
                        <li>AEON Mall Shah Alam</li>
                    </ul>
                    <p>Customers requesting delivery outside these locations may incur additional delivery charges.</p>
                </div>

                <div class="terms-card" id="sec-6">
                    <h2><span class="terms-num">6</span> Interstate Travel Policy</h2>
                    <p>Customers are allowed to drive throughout Malaysia. However:</p>
                    <div class="table-scroll">
                        <table class="terms-table">
                            <thead>
                                <tr><th>Destination</th><th>Charge</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Within Selangor</td><td>Free</td></tr>
                                <tr><td>Outside Selangor</td><td>RM50 per booking</td></tr>
                                <tr><td>Long-distance interstate travel (Northern / East Coast)</td><td>RM100 per booking</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <p>Customers must declare interstate travel during booking. Failure to declare interstate travel may result in:</p>
                    <ul>
                        <li>Insurance limitation</li>
                        <li>Additional administrative charges</li>
                        <li>Breach of rental agreement</li>
                    </ul>
                </div>

                <div class="terms-card" id="sec-7">
                    <h2><span class="terms-num">7</span> Fuel Policy</h2>
                    <p>Vehicles are provided with a specified fuel level. Customers must return the vehicle with the <strong>same fuel level</strong>. Otherwise:</p>
                    <ul>
                        <li>Fuel difference will be charged.</li>
                        <li>Administrative fee of <strong>RM30</strong> applies.</li>
                    </ul>
                </div>

                <div class="terms-card" id="sec-8">
                    <h2><span class="terms-num">8</span> Mileage Policy</h2>
                    <p>Unlimited mileage applies within Peninsular Malaysia. Excessive mileage exceeding <strong>500 km per day</strong> may be subject to inspection and additional maintenance charges if abnormal vehicle wear is identified.</p>
                </div>

                <div class="terms-card" id="sec-9">
                    <h2><span class="terms-num">9</span> Vehicle Condition</h2>
                    <p><strong>Before collection:</strong></p>
                    <ul>
                        <li>Vehicle exterior will be inspected.</li>
                        <li>Interior cleanliness will be checked.</li>
                        <li>Fuel level recorded.</li>
                        <li>Existing damages documented.</li>
                    </ul>
                    <p><strong>Upon return:</strong></p>
                    <ul>
                        <li>Vehicle condition will be inspected.</li>
                        <li>Missing accessories will be charged.</li>
                        <li>Excessive dirt or smoking smell may incur cleaning charges.</li>
                    </ul>
                </div>

                <div class="terms-card" id="sec-10">
                    <h2><span class="terms-num">10</span> Traffic Offences</h2>
                    <p>The renter is fully responsible for:</p>
                    <ul>
                        <li>Parking summons</li>
                        <li>Speeding tickets</li>
                        <li>Toll violations</li>
                        <li>JPJ offences</li>
                        <li>AES offences</li>
                    </ul>
                    <p>Administrative processing fee: <strong>RM50 per offence</strong></p>
                </div>

                <div class="terms-card" id="sec-11">
                    <h2><span class="terms-num">11</span> Accident Procedure</h2>
                    <p>If an accident occurs, the customer must:</p>
                    <ol>
                        <li>Contact SF Car Rental immediately.</li>
                        <li>Lodge a police report within <strong>24 hours</strong>.</li>
                        <li>Do not admit liability without authorization.</li>
                        <li>Submit accident photographs.</li>
                    </ol>
                    <p>Failure to comply may invalidate insurance coverage.</p>
                </div>

                <div class="terms-card" id="sec-12">
                    <h2><span class="terms-num">12</span> Prohibited Use</h2>
                    <p>The vehicle shall not be used for:</p>
                    <ul>
                        <li>Racing</li>
                        <li>Illegal activities</li>
                        <li>Carrying dangerous goods</li>
                        <li>Driver training</li>
                        <li>Off-road driving</li>
                        <li>Sub-renting</li>
                        <li>Carrying passengers for commercial e-hailing services (unless authorized)</li>
                    </ul>
                    <p>Violation may result in immediate termination of the rental agreement.</p>
                </div>

                <div class="terms-card" id="sec-13">
                    <h2><span class="terms-num">13</span> Cancellation Policy</h2>
                    <div class="table-scroll">
                        <table class="terms-table">
                            <thead>
                                <tr><th>Cancellation Time</th><th>Refund</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>More than 72 hours</td><td>Full refund</td></tr>
                                <tr><td>24 - 72 hours</td><td>50% refund</td></tr>
                                <tr><td>Less than 24 hours</td><td>No refund</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="terms-card" id="sec-14">
                    <h2><span class="terms-num">14</span> Vehicle Breakdown</h2>
                    <p>If mechanical failure occurs (not caused by customer negligence):</p>
                    <ul>
                        <li>Roadside assistance will be provided.</li>
                        <li>Replacement vehicle subject to availability.</li>
                    </ul>
                </div>

                <div class="terms-card" id="sec-15">
                    <h2><span class="terms-num">15</span> Smoking &amp; Cleanliness</h2>
                    <p>Smoking and vaping are prohibited. Cleaning charges:</p>
                    <div class="table-scroll">
                        <table class="terms-table">
                            <thead>
                                <tr><th>Situation</th><th>Charge</th></tr>
                            </thead>
                            <tbody>
                                <tr><td>Smoking smell</td><td>RM150</td></tr>
                                <tr><td>Excessive dirt</td><td>RM80</td></tr>
                                <tr><td>Pet hair cleaning</td><td>RM100</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="terms-card" id="sec-16">
                    <h2><span class="terms-num">16</span> Lost Items</h2>
                    <p>The company is not responsible for personal belongings left inside the vehicle.</p>
                </div>

                <div class="terms-card" id="sec-17">
                    <h2><span class="terms-num">17</span> Data Privacy</h2>
                    <p>Customer information will only be used for:</p>
                    <ul>
                        <li>Reservation management</li>
                        <li>Rental verification</li>
                        <li>Payment processing</li>
                        <li>Customer support</li>
                    </ul>
                    <p>The company will not disclose customer information to third parties except where required by law.</p>
                </div>

                <div class="terms-card" id="sec-18">
                    <h2><span class="terms-num">18</span> Governing Law</h2>
                    <p>All rental agreements are governed by the laws of <strong>Malaysia</strong>. Any disputes shall be resolved under the jurisdiction of the Malaysian courts.</p>
                </div>

            </div>
        </section>
    </div>

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 sfcarrental Malaysia. All Rights Reserved. Managed by SF Travel & Tours Sdn Bhd.</p>
            <div class="footer-links">
                <a href="<?= $termsUrl ?>" data-en="Terms & Conditions" data-bm="Terma & Syarat">Terms & Conditions</a> |
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

        // --- HIGHLIGHT TOC LINK AKTIF IKUT SCROLL ---
        const tocLinks = document.querySelectorAll('.terms-toc a');
        const sections = document.querySelectorAll('.terms-card');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    tocLinks.forEach(link => {
                        link.classList.toggle('active', link.getAttribute('href') === '#' + id);
                    });
                }
            });
        }, { rootMargin: '-40% 0px -50% 0px' });

        sections.forEach(sec => observer.observe(sec));
    </script>
</body>
</html>