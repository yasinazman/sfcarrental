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

    <style>
        /* CSS RESET & VARIABLES */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        :root {
            --primary-red: #E50914;
            --dark-black: #111111;
            --light-white: #FFFFFF;
            --gray-bg: #F5F5F5;
            --text-dark: #222222;
            --text-muted: #666666;
        }

        body {
            background-color: var(--light-white);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* NAVBAR */
        header {
            background-color: var(--dark-black);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
        }
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--light-white);
            text-decoration: none;
            letter-spacing: 1px;
        }
        .logo span {
            color: var(--primary-red);
        }
        .nav-links {
            display: flex;
            list-style: none;
            align-items: center;
        }
        .nav-links li {
            margin-left: 2rem;
        }
        .nav-links a {
            color: var(--light-white);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: var(--primary-red);
        }
        .btn-login {
            background-color: var(--primary-red);
            color: var(--light-white) !important;
            padding: 0.6rem 1.5rem;
            border-radius: 4px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background-color: #b8070f;
        }

        /* HERO SECTION */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?q=80&w=1920') no-repeat center center/cover;
            height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--light-white);
            padding: 0 1rem;
        }
        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        .hero-content p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            color: #cccccc;
        }
        .btn-cta {
            background-color: var(--primary-red);
            color: var(--light-white);
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            box-shadow: 0 4px 15px rgba(229, 9, 20, 0.4);
            transition: transform 0.3s, background 0.3s;
            display: inline-block;
        }
        .btn-cta:hover {
            background-color: #b8070f;
            transform: translateY(-3px);
        }

        /* SECTION STYLING */
        section {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            position: relative;
            font-weight: 700;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background-color: var(--primary-red);
            margin: 10px auto 0;
        }

        /* FLEET PREVIEW (KAD KERETA) */
        .fleet-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .car-card {
            background: var(--light-white);
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        .car-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-red);
        }
        .car-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .car-info {
            padding: 1.5rem;
        }
        .car-name {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .car-specs {
            display: flex;
            justify-content: space-between;
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
        }
        .btn-lock {
            display: block;
            text-align: center;
            background-color: var(--dark-black);
            color: var(--light-white);
            text-decoration: none;
            padding: 0.75rem;
            border-radius: 4px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-lock:hover {
            background-color: var(--primary-red);
        }

        /* WHY CHOOSE US */
        .features-bg {
            background-color: var(--gray-bg);
            max-width: 100%;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .feature-box {
            text-align: center;
            padding: 2.5rem 1.5rem;
            background: var(--light-white);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-red);
            margin-bottom: 1rem;
        }
        .feature-box h3 {
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
        }

        /* HOW IT WORKS */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            text-align: center;
        }
        .step {
            position: relative;
            padding: 1rem;
        }
        .step-num {
            width: 50px;
            height: 50px;
            background-color: var(--primary-red);
            color: var(--light-white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
            margin: 0 auto 1.5rem;
        }

        /* FOOTER */
        footer {
            background-color: var(--dark-black);
            color: var(--light-white);
            padding: 3rem 2rem;
            text-align: center;
        }
        .footer-content p {
            margin-bottom: 1rem;
            color: #888888;
        }
        .footer-links a {
            color: var(--light-white);
            text-decoration: none;
            margin: 0 1rem;
            transition: color 0.3s;
        }
        .footer-links a:hover {
            color: var(--primary-red);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .hero-content h1 { font-size: 2.3rem; }
            .navbar { flex-direction: column; gap: 1rem; }
            .nav-links { padding-left: 0; }
            .nav-links li { margin: 0 1rem; }
        }
    </style>
</head>
<body>

    <header>
        <div class="navbar">
            <a href="#" class="logo">sf<span>carrental</span></a>
            <ul class="nav-links">
                <li><a href="#utama">Utama</a></li>
                <li><a href="#kereta">Koleksi Kereta</a></li>
                <li><a href="#kelebihan">Kelebihan</a></li>
                <li><a href="#" class="btn-login">Log Masuk / Daftar</a></li>
            </ul>
        </div>
    </header>

    <main id="utama">
        <div class="hero">
            <div class="hero-content">
                <h1>Sewa Kereta Impian Anda Dengan Mudah</h1>
                <p>Harga telus, kereta bersih, dan servis pantas. Daftar akaun sfcarrental hari ini.</p>
                <a href="#" class="btn-cta">Semak Kereta Tersedia</a>
            </div>
        </div>
    </main>

    <section id="car-fleet">
        <h2 class="section-title" id="kereta">Pilihan Kereta Popular</h2>
        <div class="fleet-grid">
            
            <div class="car-card">
                <img src="https://peroduapj.com.my/wp-content/uploads/2015/12/perodua-axia-color-377345.webp" alt="Perodua Axia" class="car-img">
                <div class="car-info">
                    <div class="car-name">Ekonomi (Perodua Axia)</div>
                    <div class="car-specs">
                        <span>👤 4 Tempat Duduk</span>
                        <span>⚙️ Auto</span>
                        <span>🧳 1 Bagasi</span>
                    </div>
                    <a href="#" class="btn-lock">🔑 Log Masuk Untuk Tempah</a>
                </div>
            </div>

            <div class="car-card">
                <img src="https://www.gemcarrental.com.my/wp-content/uploads/2022/04/bezza-left-square.jpg" alt="Perodua Bezza" class="car-img">
                <div class="car-info">
                    <div class="car-name">Sedan (Perodua Bezza)</div>
                    <div class="car-specs">
                        <span>👤 5 Tempat Duduk</span>
                        <span>⚙️ Auto</span>
                        <span>🧳 2 Bagasi</span>
                    </div>
                    <a href="#" class="btn-lock">🔑 Log Masuk Untuk Tempah</a>
                </div>
            </div>

            <div class="car-card">
                <img src="https://dodomat.com.my/cdn/shop/files/car_mat_proton_x50_2020-800x800_a8330c0f-9661-4eeb-a5ad-06e2a349a6b7.jpg?v=1732870426" alt="Proton X50 Lookalike" class="car-img">
                <div class="car-info">
                    <div class="car-name">SUV (Proton X50)</div>
                    <div class="car-specs">
                        <span>👤 5 Tempat Duduk</span>
                        <span>⚙️ Auto</span>
                        <span>🧳 4 Bagasi</span>
                    </div>
                    <a href="#" class="btn-lock">🔑 Log Masuk Untuk Tempah</a>
                </div>
            </div>

            <div class="car-card">
                <img src="https://peroduasale.com.my/wp-content/uploads/2024/08/Perodua-Alza.png" alt="Perodua Alza Lookalike" class="car-img">
                <div class="car-info">
                    <div class="car-name">MPV (Perodua Alza)</div>
                    <div class="car-specs">
                        <span>👤 7 Tempat Duduk</span>
                        <span>⚙️ Auto</span>
                        <span>🧳 5 Bagasi</span>
                    </div>
                    <a href="#" class="btn-lock">🔑 Log Masuk Untuk Tempah</a>
                </div>
            </div>

            <div class="car-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTb7nWdYEIwWfVqXY2yuhIXq9RnHnJzA8KSESLx_9YsdEflG6mmBlZR7dox&s=10" alt="BMW M5 F90 Lookalike" class="car-img">
                <div class="car-info">
                    <div class="car-name">Luxury (BMW M5 F90)</div>
                    <div class="car-specs">
                        <span>👤 5 Tempat Duduk</span>
                        <span>⚙️ Auto</span>
                        <span>🧳 4 Bagasi</span>
                    </div>
                    <a href="#" class="btn-lock">🔑 Log Masuk Untuk Tempah</a>
                </div>
            </div>

            <div class="car-card">
                <img src="https://assets.nst.com.my/images/articles/Triton_Athlete-Side_Quarter_Visual_1617871938.jpg" alt="Mitsubishi Triton Lookalike" class="car-img">
                <div class="car-info">
                    <div class="car-name">4x4 (Mitsubishi Triton)</div>
                    <div class="car-specs">
                        <span>👤 5 Tempat Duduk</span>
                        <span>⚙️ Auto</span>
                        <span>🧳 12 Bagasi</span>
                    </div>
                    <a href="#" class="btn-lock">🔑 Log Masuk Untuk Tempah</a>
                </div>
            </div>

        </div>
    </section>

    <div class="features-bg" id="kelebihan">
        <section>
            <h2 class="section-title">Kenapa Pilih sfcarrental?</h2>
            <div class="features-grid">
                <div class="feature-box">
                    <div class="feature-icon">✨</div>
                    <h3>Kereta Sentiasa Bersih</h3>
                    <p>Setiap kenderaan disinfeksi dan diservis sebelum diserahkan kepada anda.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">💰</div>
                    <h3>Tiada Caj Tersembunyi</h3>
                    <p>Harga yang anda lihat adalah harga yang anda bayar. Telus dan adil.</p>
                </div>
                <div class="feature-box">
                    <div class="feature-icon">🛠️</div>
                    <h3>Bantuan Jalanraya 24/7</h3>
                    <p>Kami sentiasa bersedia membantu anda sekiranya berlaku sebarang kecemasan.</p>
                </div>
            </div>
        </section>
    </div>

    <section>
        <h2 class="section-title">3 Langkah Mudah Untuk Memandu</h2>
        <div class="steps-grid">
            <div class="step">
                <div class="step-num">1</div>
                <h3>Daftar & Log Masuk</h3>
                <p>Cipta akaun sfcarrental anda dengan selamat dalam masa 1 minit sahaja.</p>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <h3>Pilih Kereta & Tarikh</h3>
                <p>Akses dashboard tempahan kami, pilih kenderaan dan tarikh yang anda mahu.</p>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <h3>Ambil & Pandu</h3>
                <p>Selesaikan pembayaran atas talian dan ambil kereta di lokasi pilihan anda.</p>
            </div>
        </div>
    </section>

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
