<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sfcarrental | <?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('home') ?>
    <?= $this->fetch('css') ?>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="page-home">

    <!-- Floating Theme Toggle -->
    <button id="theme-toggle-float" class="theme-btn-float" title="Toggle Dark/Light Mode">
        <i class="fa-solid fa-moon"></i>
    </button>

    <!-- Sign In / Register Modal Overlay -->
    <div class="signin-overlay" id="signin-overlay">
        <div class="signin-modal">
            <button class="signin-close" id="signin-close" title="Close"><i class="fa-solid fa-xmark"></i></button>
            <div class="signin-icon"><i class="fa-solid fa-circle-user"></i></div>
            <h3 data-en="Welcome to sfcarrental" data-bm="Selamat Datang ke sfcarrental">Welcome to sfcarrental</h3>
            <p data-en="Please select how you want to continue" data-bm="Sila pilih cara anda mahu teruskan">Please select how you want to continue</p>
            <div class="signin-options">
                <a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'login']) ?>" class="signin-option-btn">
                    <i class="fa fa-user"></i> 
                    <span data-en="Continue as User" data-bm="Teruskan sebagai Pengguna">Continue as User</span>
                </a>
                <a href="<?= $this->Url->build(['controller' => 'Admins', 'action' => 'login']) ?>" class="signin-option-btn admin">
                    <i class="fa-solid fa-user-shield"></i>
                    <span data-en="Continue as Admin" data-bm="Teruskan sebagai Admin">Continue as Admin</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Top Bar -->
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

    <!-- Main Navigation -->
    <header>
        <div class="navbar">
            <a href="<?= $this->Url->build('/') ?>" class="logo">sf<span>carrental</span></a>
            <ul class="nav-links">
                <li><a href="<?= $this->Url->build('/') ?>" data-en="Home" data-bm="Utama">Home</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Categories', 'action' => 'index']) ?>" data-en="Categories" data-bm="Kategori">Categories</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Fleets', 'action' => 'index']) ?>" data-en="Our Fleet" data-bm="Koleksi Kereta">Our Fleet</a></li>
                <li><a href="<?= $this->Url->build('/#kelebihan') ?>" data-en="Why Us" data-bm="Kelebihan">Why Us</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Terms', 'action' => 'index']) ?>" data-en="Terms & Conditions" data-bm="Terma & Syarat">Terms & Conditions</a></li>
                
                <?php 
                    // Pastikan tiada ralat jika pembolehubah kosong
                    $userLogged = $userLogged ?? null;
                    $namaPengguna = '';

                    if ($userLogged) {
                        // Semak jika data adalah Object (Entity CakePHP)
                        if (is_object($userLogged)) {
                            $namaPengguna = $userLogged->full_name ?? $userLogged->name ?? 'Pengguna';
                        } 
                        // Semak jika data adalah Array biasa
                        elseif (is_array($userLogged)) {
                            $namaPengguna = $userLogged['full_name'] ?? $userLogged['name'] ?? 'Pengguna';
                        }
                    }
                ?>

                <?php if ($userLogged): ?>
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'dashboard']) ?>" 
                           style="color: var(--primary-red); font-weight: 700;">My Dashboard</a>
                    </li>
                    <li>
                        <?= $this->Html->link(
                            __('<i class="fa-solid fa-right-from-bracket"></i> Logout <span class="user-name">(' . h($namaPengguna) . ')</span>'),
                            ['controller' => 'Customers', 'action' => 'logout'],
                            ['class' => 'btn-logout', 'escape' => false]
                        ) ?>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="#" id="btn-signin" class="btn-signin" style="background-color: var(--primary-red, #e60000); color: white; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: bold; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fa-solid fa-user"></i> <span data-en="Sign In / Register" data-bm="Log Masuk / Daftar">Sign In / Register</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>

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
            // Tukar teks biasa
            document.querySelectorAll('[data-en]').forEach(element => {
                if (lang === 'en') {
                    element.innerHTML = element.getAttribute('data-en');
                } else {
                    element.innerHTML = element.getAttribute('data-bm');
                }
            });

            // Tukar placeholder input
            const destInput = document.querySelector('input[name="destination"]');
            if(destInput) {
                destInput.placeholder = lang === 'en' ? destInput.getAttribute('data-en-placeholder') : destInput.getAttribute('data-bm-placeholder');
            }

            // Tukar teks dalam <select>
            document.querySelectorAll('select option[data-en]').forEach(option => {
                if (lang === 'en') {
                    option.textContent = option.getAttribute('data-en');
                } else {
                    option.textContent = option.getAttribute('data-bm');
                }
            });
        }

        if(btnEn && btnBm) {
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
        }

        // --- LOGIK SIGN IN / REGISTER MODAL ---
        const btnSignIn = document.getElementById('btn-signin');
        const signinOverlay = document.getElementById('signin-overlay');
        const signinClose = document.getElementById('signin-close');

        if(btnSignIn) {
            btnSignIn.addEventListener('click', (e) => {
                e.preventDefault();
                signinOverlay.classList.add('active');
            });
        }
        if(signinClose) {
            signinClose.addEventListener('click', () => signinOverlay.classList.remove('active'));
        }
        if(signinOverlay) {
            signinOverlay.addEventListener('click', (e) => {
                if (e.target === signinOverlay) signinOverlay.classList.remove('active');
            });
        }
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && signinOverlay) signinOverlay.classList.remove('active');
        });

        // --- LOGIK DARK MODE ---
        const themeToggleFloat = document.getElementById('theme-toggle-float');
        
        function updateButtonIcon(theme) {
            if (theme === 'dark') {
                themeToggleFloat.innerHTML = '<i class="fa-solid fa-sun"></i>';
                themeToggleFloat.title = "Switch to Light Mode";
            } else {
                themeToggleFloat.innerHTML = '<i class="fa-solid fa-moon"></i>';
                themeToggleFloat.title = "Switch to Dark Mode";
            }
        }

        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            document.documentElement.classList.add('dark-theme');
            document.body.classList.add('dark-theme');
            updateButtonIcon('dark');
        } else {
            updateButtonIcon('light');
        }

        if(themeToggleFloat) {
            themeToggleFloat.addEventListener('click', () => {
                const isDark = document.body.classList.toggle('dark-theme');
                document.documentElement.classList.toggle('dark-theme', isDark);
                
                const newTheme = isDark ? 'dark' : 'light';
                localStorage.setItem('theme', newTheme);
                updateButtonIcon(newTheme);
            });
        }
    </script>
</body>
</html>