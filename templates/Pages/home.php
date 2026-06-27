<?php
/**
 * sfcarrental - Preview Homepage
 * @var \App\View\AppView $this
 */

$this->disableAutoLayout();
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sfcarrental | Sewa Kereta Mudah & Pantas</title>
    <?= $this->Html->meta('icon') ?>
    
    <?= $this->Html->css('home') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header>
        <div class="navbar">
            <a href="#" class="logo">sf<span>carrental</span></a>
            <ul class="nav-links">
                <li><a href="#utama">Utama</a></li>
                <li><a href="#kategori-section">Kategori</a></li>
                <li><a href="#kereta-section">Koleksi Kereta</a></li>
                <li><a href="#kelebihan">Kelebihan</a></li>
                <li><a href="#" class="btn-login">Log Masuk / Daftar</a></li>
            </ul>
        </div>
    </header>

    <main id="utama" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Sewa Kereta Impian Anda Dengan Mudah</h1>
                <p>Harga telus, kereta bersih, dan servis pantas di seluruh Malaysia.</p>
            </div>

            <div class="booking-form-container">
                <form action="#" method="GET" class="booking-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label><i class="fa-solid fa-location-dot"></i> Lokasi Ambil (Pick Up)</label>
                            <select name="pickup_location" required>
                                <option value="">Pilih Lokasi Ambil...</option>
                                <option value="KLIA">KLIA / KLIA2</option>
                                <option value="KL">Kuala Lumpur</option>
                                <option value="Shah Alam">Shah Alam, Selangor</option>
                                <option value="Penang">Pulau Pinang</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><i class="fa-solid fa-map-location-dot"></i> Lokasi Destinasi (Destinasi Utama)</label>
                            <input type="text" name="destination" placeholder="Contoh: Johor Bahru, Ipoh..." required>
                        </div>

                        <div class="form-group">
                            <label><i class="fa-solid fa-calendar-plus"></i> Tarikh & Masa Ambil</label>
                            <input type="datetime-local" name="pickup_date" required>
                        </div>

                        <div class="form-group">
                            <label><i class="fa-solid fa-calendar-minus"></i> Tarikh & Masa Pulang</label>
                            <input type="datetime-local" name="return_date" required>
                        </div>

                        <div class="form-group">
                            <label><i class="fa-solid fa-car-side"></i> Jenis Kereta</label>
                            <select name="car_type">
                                <option value="all">Semua Jenis Kereta</option>
                                <option value="ekonomi">Ekonomi / Hatchback</option>
                                <option value="sedan">Sedan</option>
                                <option value="suv">SUV</option>
                                <option value="mpv">MPV</option>
                                <option value="luxury">Luxury</option>
                            </select>
                        </div>

                        <div class="form-group btn-container">
                            <button type="submit" class="btn-search">
                                <i class="fa-solid fa-magnifying-glass"></i> Cari Kereta
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <section id="kategori-section" class="categories-container">
        <h2 class="section-title">Ikut Kategori Pilihan</h2>
        <div class="categories-grid">
            <div class="category-card active"><i class="fa-solid fa-car"></i> Semua</div>
            <div class="category-card"><i class="fa-solid fa-gas-pump"></i> Ekonomi</div>
            <div class="category-card"><i class="fa-solid fa-car-side"></i> Sedan</div>
            <div class="category-card"><i class="fa-solid fa-cloud-sun"></i> SUV</div>
            <div class="category-card"><i class="fa-solid fa-users"></i> MPV</div>
            <div class="category-card"><i class="fa-solid fa-gem"></i> Mewah</div>
        </div>
    </section>

    <section id="kereta-section">
        <h2 class="section-title">Pilihan Kereta Popular</h2>
        <div class="fleet-grid">
            
            <div class="car-card">
                <div class="car-tag">Ekonomi</div>
                <img src="https://peroduapj.com.my/wp-content/uploads/2015/12/perodua-axia-color-377345.webp" alt="Perodua Axia" class="car-img">
                <div class="car-info">
                    <div class="car-name">Perodua Axia</div>
                    
                    <div class="car-specs">
                        <span><i class="fa-solid fa-user"></i> 4 Tempat Duduk</span>
                        <span><i class="fa-solid fa-gear"></i> Auto</span>
                    </div>

                    <div class="car-extra-details">
                        <div class="detail-item"><i class="fa-solid fa-gas-pump"></i> <span>Fuel:</span> Petrol (EEV)</div>
                        <div class="detail-item"><i class="fa-solid fa-circle-dot"></i> <span>Spare Tyre:</span> Ada</div>
                        <div class="detail-item"><i class="fa-solid fa-baby-carriage"></i> <span>Child Seat:</span> Request (Sewa)</div>
                        <div class="detail-item"><i class="fa-solid fa-wrench"></i> <span>Spec:</span> 1.0L G-Spec</div>
                    </div>

                    <a href="#" class="btn-lock"><i class="fa-solid fa-key"></i> Log Masuk Untuk Tempah</a>
                </div>
            </div>

            <div class="car-card">
                <div class="car-tag">Sedan</div>
                <img src="https://www.gemcarrental.com.my/wp-content/uploads/2022/04/bezza-left-square.jpg" alt="Perodua Bezza" class="car-img">
                <div class="car-info">
                    <div class="car-name">Perodua Bezza</div>
                    <div class="car-specs">
                        <span><i class="fa-solid fa-user"></i> 5 Tempat Duduk</span>
                        <span><i class="fa-solid fa-gear"></i> Auto</span>
                    </div>
                    <div class="car-extra-details">
                        <div class="detail-item"><i class="fa-solid fa-gas-pump"></i> <span>Fuel:</span> Petrol</div>
                        <div class="detail-item"><i class="fa-solid fa-circle-dot"></i> <span>Spare Tyre:</span> Ada</div>
                        <div class="detail-item"><i class="fa-solid fa-baby-carriage"></i> <span>Child Seat:</span> Request (Sewa)</div>
                        <div class="detail-item"><i class="fa-solid fa-wrench"></i> <span>Spec:</span> 1.3L Premium X</div>
                    </div>
                    <a href="#" class="btn-lock"><i class="fa-solid fa-key"></i> Log Masuk Untuk Tempah</a>
                </div>
            </div>

            <div class="car-card">
                <div class="car-tag">SUV</div>
                <img src="https://dodomat.com.my/cdn/shop/files/car_mat_proton_x50_2020-800x800_a8330c0f-9661-4eeb-a5ad-06e2a349a6b7.jpg?v=1732870426" alt="Proton X50" class="car-img">
                <div class="car-info">
                    <div class="car-name">Proton X50</div>
                    <div class="car-specs">
                        <span><i class="fa-solid fa-user"></i> 5 Tempat Duduk</span>
                        <span><i class="fa-solid fa-gear"></i> Auto</span>
                    </div>
                    <div class="car-extra-details">
                        <div class="detail-item"><i class="fa-solid fa-gas-pump"></i> <span>Fuel:</span> Petrol Turbo</div>
                        <div class="detail-item"><i class="fa-solid fa-circle-dot"></i> <span>Spare Tyre:</span> Ruang Khas (Tersedia)</div>
                        <div class="detail-item"><i class="fa-solid fa-baby-carriage"></i> <span>Child Seat:</span> ISOFIX (Tersedia)</div>
                        <div class="detail-item"><i class="fa-solid fa-wrench"></i> <span>Spec:</span> 1.5T Flagship</div>
                    </div>
                    <a href="#" class="btn-lock"><i class="fa-solid fa-key"></i> Log Masuk Untuk Tempah</a>
                </div>
            </div>

        </div>
    </section>

    <div class="features-bg" id="kelebihan">
        <section>
            <h2 class="section-title">Kenapa Pilih sfcarrental?</h2>
            <div class="features-grid">
                <div class="feature-box">
                    <div class="feature-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                    <h3>Kereta Sentiasa Bersih</h3>
                    <p>Setiap kenderaan disinfeksi dan diservis sebelum diserahkan kepada anda.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                    <h3>Tiada Caj Tersembunyi</h3>
                    <p>Harga yang anda lihat adalah harga yang anda bayar. Telus dan adil.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon"><i class="fa-solid fa-headset"></i></div>
                    <h3>Bantuan Jalanraya 24/7</h3>
                    <p>Kami sentiasa bersedia membantu anda sekiranya berlaku sebarang kecemasan.</p>
                </div>
            </div>
        </section>
    </div>

    <footer>
        <div class="footer-content">
            <p>&copy; 2026 sfcarrental. Hak Cipta Terpelihara.</p>
            <div class="footer-links">
                <a href="#">Terma & Syarat</a> | 
                <a href="#">Dasar Privasi</a> | 
                <a href="#">Hubungi Kami</a>
            </div>
        </div>
    </footer>

</body>
</html>