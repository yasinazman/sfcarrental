<?php
/**
 * sfcarrental - Preview Homepage (Premium Tourist Edition with Float Dark Mode & Language)
 * @var \App\View\AppView $this
 */
$this->disableAutoLayout();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sfcarrental | Premium Car Rental & Airport Transfer</title>
    <?= $this->Html->meta('icon') ?>
    
    <?= $this->Html->css('home') ?>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <button id="theme-toggle-float" class="theme-btn-float" title="Toggle Dark/Light Mode">
        <i class="fa-solid fa-moon"></i>
    </button>

    <div class="top-bar">
        <div class="top-bar-container">
            <div class="top-info">
                <span><i class="fa-solid fa-plane-arrival"></i> <span data-en="Free KLIA1 & KLIA2 Airport Pickup" data-bm="Pengambilan Percuma di Airport KLIA1 & KLIA2">Free KLIA1 & KLIA2 Airport Pickup</span></span>
                <span><i class="fa-solid fa-headset"></i> <span data-en="24/7 Tourist Support: " data-bm="Bantuan Pelancong 24/7: ">24/7 Tourist Support: </span>+6012-3456789</span>
            </div>
            <div class="top-langs">
                <span id="lang-en" class="lang-btn active">EN</span> | <span id="lang-bm" class="lang-btn">BM</span>
            </div>
        </div>
    </div>

    <header>
        <div class="navbar">
            <a href="#" class="logo">sf<span>carrental</span></a>
            <ul class="nav-links">
                <li><a href="#utama" data-en="Home" data-bm="Utama">Home</a></li>
                <li><a href="#kategori-section" data-en="Categories" data-bm="Kategori">Categories</a></li>
                <li><a href="#kereta-section" data-en="Our Fleet" data-bm="Koleksi Kereta">Our Fleet</a></li>
                <li><a href="#kelebihan" data-en="Why Us" data-bm="Kelebihan">Why Us</a></li>
                <li><a href="#" class="btn-login"><i class="fa-solid fa-user-plus"></i> <span data-en="Sign In / Register" data-bm="Log Masuk / Daftar">Sign In / Register</span></a></li>
            </ul>
        </div>
    </header>

    <main id="utama" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <span class="hero-badge" data-en="✨ Malaysia's Top Choice for Travelers" data-bm="✨ Pilihan Utama Pelancong di Malaysia">✨ Malaysia's Top Choice for Travelers</span>
                <h1 data-en="Explore Malaysia With Absolute Freedom" data-bm="Terokai Malaysia Dengan Kebebasan Mutlak">Explore Malaysia With Absolute Freedom</h1>
                <p data-en="Transparent pricing, pristine cars, and seamless airport handovers. No hidden tourist surcharges." data-bm="Harga telus, kereta bersih, dan penyerahan mudah di lapangan terbang. Tiada caj tersembunyi.">Transparent pricing, pristine cars, and seamless airport handovers. No hidden tourist surcharges.</p>
            </div>

            <div class="booking-form-container">
                <div class="form-tabs">
                    <button class="tab-btn active"><i class="fa-solid fa-car"></i> <span data-en="Self Drive" data-bm="Pandu Sendiri">Self Drive</span></button>
                    <button class="tab-btn"><i class="fa-solid fa-user-tie"></i> <span data-en="With Chauffeur" data-bm="Dengan Pemandu">With Chauffeur</span></button>
                </div>
                
                <form action="#" method="GET" class="booking-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label><i class="fa-solid fa-location-dot"></i> <span data-en="Pick-up Location" data-bm="Lokasi Ambil">Pick-up Location</span></label>
                            <select name="pickup_location" required>
                                <option value="" data-en="Select Location..." data-bm="Pilih Lokasi...">Select Location...</option>
                                <option value="KLIA">KLIA Terminal 1 / 2 (Airport)</option>
                                <option value="KL">Kuala Lumpur City Centre</option>
                                <option value="Penang">Penang International Airport</option>
                                <option value="JB">Johor Bahru (Customs / Airport)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fa-solid fa-map-location-dot"></i> <span data-en="Where are you heading to?" data-bm="Lokasi Destinasi">Where are you heading to?</span></label>
                            <input type="text" name="destination" placeholder="e.g., Genting Highlands..." data-en-placeholder="e.g., Genting Highlands, Melaka..." data-bm-placeholder="e.g., Genting Highlands, Melaka..." required>
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
                            <label><i class="fa-solid fa-car-side"></i> <span data-en="Vehicle Class" data-bm="Jenis Kereta">Vehicle Class</span></label>
                            <select name="car_type">
                                <option value="all" data-en="All Vehicle Classes" data-bm="Semua Jenis Kereta">All Vehicle Classes</option>
                                <option value="ekonomi" data-en="Budget / Economy" data-bm="Bajet / Ekonomi">Budget / Economy</option>
                                <option value="sedan" data-en="Standard Sedan" data-bm="Sedan Standard">Standard Sedan</option>
                                <option value="suv" data-en="SUV / Crossover" data-bm="SUV / Crossover">SUV / Crossover</option>
                                <option value="mpv" data-en="Family MPV (7-Seater)" data-bm="MPV Keluarga (7-Tempat)">Family MPV (7-Seater)</option>
                                <option value="luxury" data-en="Luxury & Sports" data-bm="Mewah & Sukan">Luxury & Sports</option>
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
        </div>
    </main>

    <div class="content-wrapper-centered">

        <section class="trust-badges">
            <div class="badge-item">
                <i class="fa-solid fa-shield-halved"></i>
                <div>
                    <h4 data-en="Full Insurance Coverage" data-bm="Perlindungan Insurans Penuh">Full Insurance Coverage</h4>
                    <p data-en="CDW & Theft protection included" data-bm="Perlindungan CDW & kecurian disertakan">CDW & Theft protection included</p>
                </div>
            </div>
            <div class="badge-item">
                <i class="fa-solid fa-ban"></i>
                <div>
                    <h4 data-en="Free Cancellation" data-bm="Pembatalan Percuma">Free Cancellation</h4>
                    <p data-en="Up to 24 hours before pickup" data-bm="Sehingga 24 jam sebelum ambil">Up to 24 hours before pickup</p>
                </div>
            </div>
            <div class="badge-item">
                <i class="fa-solid fa-percentage"></i>
                <div>
                    <h4 data-en="No Credit Card Fees" data-bm="Tiada Caj Kad Kredit">No Credit Card Fees</h4>
                    <p data-en="Zero hidden processing surcharges" data-bm="Tiada caj pemprosesan tersembunyi">Zero hidden processing surcharges</p>
                </div>
            </div>
        </section>

        <section id="kategori-section" class="categories-container">
            <h2 class="section-title" data-en="Browse by Vehicle Category" data-bm="Ikut Kategori Pilihan">Browse by Vehicle Category</h2>
            <div class="categories-grid">
                <div class="category-card active"><i class="fa-solid fa-border-all"></i> <span data-en="All Cars" data-bm="Semua">All Cars</span></div>
                <div class="category-card"><i class="fa-solid fa-leaf"></i> <span data-en="Economy" data-bm="Ekonomi">Economy</span></div>
                <div class="category-card"><i class="fa-solid fa-car-side"></i> <span data-en="Sedan" data-bm="Sedan">Sedan</span></div>
                <div class="category-card"><i class="fa-solid fa-cloud-sun"></i> <span data-en="SUV" data-bm="SUV">SUV</span></div>
                <div class="category-card"><i class="fa-solid fa-users"></i> <span data-en="MPV (Family)" data-bm="MPV (Keluarga)">MPV (Family)</span></div>
                <div class="category-card"><i class="fa-solid fa-gem"></i> <span data-en="Luxury" data-bm="Mewah">Luxury</span></div>
            </div>
        </section>

        <section id="kereta-section" class="fleet-section">
            <h2 class="section-title" data-en="Our International Standard Fleet" data-bm="Pilihan Kereta Standard Antarabangsa">Our International Standard Fleet</h2>
            <div class="fleet-grid">
                
                <div class="car-card">
                    <div class="car-tag" data-en="Economy / Compact" data-bm="Ekonomi / Kompak">Economy / Compact</div>
                    <img src="https://peroduapj.com.my/wp-content/uploads/2015/12/perodua-axia-color-377345.webp" alt="Perodua Axia" class="car-img">
                    <div class="car-info">
                        <div class="car-name">Perodua Axia <span data-en="or similar" data-bm="atau setaraf">or similar</span></div>
                        <div class="price-box">
                            <span class="currency">MYR</span> <span class="amount">110</span> <span class="per-day">/day</span>
                            <span class="usd-convert">≈ $25 USD</span>
                        </div>
                        <div class="car-specs">
                            <span><i class="fa-solid fa-user"></i> <span data-en="4 Seats" data-bm="4 Tempat">4 Seats</span></span>
                            <span><i class="fa-solid fa-gear"></i> Automatic</span>
                            <span><i class="fa-solid fa-suitcase"></i> 1 Bag</span>
                        </div>
                        <div class="car-extra-details">
                            <div class="detail-item"><i class="fa-solid fa-gas-pump"></i> <span>Fuel:</span> Petrol</div>
                            <div class="detail-item"><i class="fa-solid fa-circle-dot"></i> <span data-en="Spare Tyre:" data-bm="Tayar Ganti:">Spare Tyre:</span> <span data-en="Included" data-bm="Disediakan">Included</span></div>
                            <div class="detail-item"><i class="fa-solid fa-baby-carriage"></i> <span>Child Seat:</span> Request</div>
                            <div class="detail-item"><i class="fa-solid fa-wrench"></i> <span>Specs:</span> 1.0L Dual VVT-i</div>
                        </div>
                        <a href="#" class="btn-lock"><i class="fa-solid fa-calendar-check"></i> <span data-en="Book Now & Pay Later" data-bm="Tempah & Bayar Kemudian">Book Now & Pay Later</span></a>
                    </div>
                </div>

                <div class="car-card">
                    <div class="car-tag">SUV / Crossover</div>
                    <img src="https://dodomat.com.my/cdn/shop/files/car_mat_proton_x50_2020-800x800_a8330c0f-9661-4eeb-a5ad-06e2a349a6b7.jpg?v=1732870426" alt="Proton X50" class="car-img">
                    <div class="car-info">
                        <div class="car-name">Proton X50 <span>Premium SUV</span></div>
                        <div class="price-box">
                            <span class="currency">MYR</span> <span class="amount">250</span> <span class="per-day">/day</span>
                            <span class="usd-convert">≈ $58 USD</span>
                        </div>
                        <div class="car-specs">
                            <span><i class="fa-solid fa-user"></i> <span data-en="5 Seats" data-bm="5 Tempat">5 Seats</span></span>
                            <span><i class="fa-solid fa-gear"></i> Automatic</span>
                            <span><i class="fa-solid fa-suitcase"></i> 3 Bags</span>
                        </div>
                        <div class="car-extra-details">
                            <div class="detail-item"><i class="fa-solid fa-gas-pump"></i> <span>Fuel:</span> Petrol (Turbo)</div>
                            <div class="detail-item"><i class="fa-solid fa-circle-dot"></i> <span data-en="Spare Tyre:" data-bm="Tayar Ganti:">Spare Tyre:</span> <span data-en="Built-in" data-bm="Sedia Ada">Built-in</span></div>
                            <div class="detail-item"><i class="fa-solid fa-baby-carriage"></i> <span>Child Seat:</span> ISOFIX</div>
                            <div class="detail-item"><i class="fa-solid fa-wrench"></i> <span>Specs:</span> 1.5L Turbo</div>
                        </div>
                        <a href="#" class="btn-lock"><i class="fa-solid fa-calendar-check"></i> <span data-en="Book Now & Pay Later" data-bm="Tempah & Bayar Kemudian">Book Now & Pay Later</span></a>
                    </div>
                </div>

                <div class="car-card">
                    <div class="car-tag" data-en="MPV / 7-Seater" data-bm="MPV / 7-Tempat">MPV / 7-Seater</div>
                    <img src="https://peroduasale.com.my/wp-content/uploads/2024/08/Perodua-Alza.png" alt="Perodua Alza" class="car-img">
                    <div class="car-info">
                        <div class="car-name">Perodua Alza <span>New Model</span></div>
                        <div class="price-box">
                            <span class="currency">MYR</span> <span class="amount">180</span> <span class="per-day">/day</span>
                            <span class="usd-convert">≈ $42 USD</span>
                        </div>
                        <div class="car-specs">
                            <span><i class="fa-solid fa-user"></i> <span data-en="7 Seats" data-bm="7 Tempat">7 Seats</span></span>
                            <span><i class="fa-solid fa-gear"></i> Automatic</span>
                            <span><i class="fa-solid fa-suitcase"></i> 4 Bags</span>
                        </div>
                        <div class="car-extra-details">
                            <div class="detail-item"><i class="fa-solid fa-gas-pump"></i> <span>Fuel:</span> Petrol EEV</div>
                            <div class="detail-item"><i class="fa-solid fa-circle-dot"></i> <span data-en="Spare Tyre:" data-bm="Tayar Ganti:">Spare Tyre:</span> <span data-en="Included" data-bm="Disediakan">Included</span></div>
                            <div class="detail-item"><i class="fa-solid fa-baby-carriage"></i> <span>Child Seat:</span> ISOFIX</div>
                            <div class="detail-item"><i class="fa-solid fa-wrench"></i> <span>Specs:</span> 1.5L H-Advance</div>
                        </div>
                        <a href="#" class="btn-lock"><i class="fa-solid fa-calendar-check"></i> <span data-en="Book Now & Pay Later" data-bm="Tempah & Bayar Kemudian">Book Now & Pay Later</span></a>
                    </div>
                </div>

            </div>
        </section>

        <div class="features-bg-container" id="kelebihan">
            <section class="features-section-inner">
                <h2 class="section-title" data-en="Why Tourists Choose sfcarrental?" data-bm="Kenapa Pelancong Pilih sfcarrental?">Why Tourists Choose sfcarrental?</h2>
                <div class="features-grid">
                    <div class="feature-box">
                        <div class="feature-icon"><i class="fa-solid fa-sparkles"></i></div>
                        <h3 data-en="5-Star Hygiene Clean" data-bm="Kebersihan Gred 5-Bintang">5-Star Hygiene Clean</h3>
                        <p data-en="Every single vehicle undergoes full medical-grade sanitization and multi-point inspection before handover." data-bm="Setiap kenderaan dinyahkuman sepenuhnya menggunakan gred perubatan sebelum diserahkan.">Every single vehicle undergoes full medical-grade sanitization and multi-point inspection before handover.</p>
                    </div>
                    <div class="feature-box">
                        <div class="feature-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                        <h3 data-en="True Pricing Guarantee" data-bm="Jaminan Harga Sebenar">True Pricing Guarantee</h3>
                        <p data-en="What you see is exactly what you pay. No local taxes added at counter, no seasonal tourist markups." data-bm="Harga tertera adalah harga dibayar. Tiada cukai tambahan kaunter atau caj tersembunyi bermusim.">What you see is exactly what you pay. No local taxes added at counter, no seasonal tourist markups.</p>
                    </div>
                    <div class="feature-box">
                        <div class="feature-icon"><i class="fa-solid fa-road-circle-check"></i></div>
                        <h3 data-en="24/7 Roadside Assistance" data-bm="Bantuan Kecemasan Jalan Raya 24/7">24/7 Roadside Assistance</h3>
                        <p data-en="Drive with peace of mind. Our dedicated English-speaking emergency team is ready to assist you anywhere, anytime." data-bm="Pandu tanpa risau. Pasukan bantuan kecemasan bersiap sedia membantu anda di mana-mana sahaja.">Drive with peace of mind. Our dedicated English-speaking emergency team is ready to assist you anywhere, anytime.</p>
                    </div>
                </div>
            </section>
        </div>

    </div> <footer>
        <div class="footer-content">
            <p>&copy; 2026 sfcarrental Malaysia. All Rights Reserved. Managed by SF Travel & Tours Sdn Bhd.</p>
            <div class="footer-links">
                <a href="#" data-en="Terms & Conditions" data-bm="Terma & Syarat">Terms & Conditions</a> | 
                <a href="#" data-en="Privacy Policy" data-bm="Dasar Privasi">Privacy Policy</a> | 
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
            if(destInput) {
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

        // --- LOGIK DARK MODE TERAPUNG (FLOATING TOGGLE) ---
        const themeToggleFloat = document.getElementById('theme-toggle-float');
        
        // Simpan mod pilihan dalam localStorage supaya tak hilang bila tukar page/refresh
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