<?php
/**
 * @var \App\View\AppView $this
 */
// Panggil CSS user-dashboard dari webroot/css/user-dashboard.css
echo $this->Html->css('user-dashboard'); 
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-lang-en="User Dashboard - SFCARRENTAL" data-lang-bm="Panel Pengguna - SFCARRENTAL">User Dashboard - SFCARRENTAL</title>
</head>
<body>

<div class="user-dashboard-wrapper">
    <div class="sidebar-user">
        <div class="brand-user">SFCARRENTAL</div>
        
        <ul class="menu-user">
            <li class="active">
                <a href="#" data-lang-en="Dashboard" data-lang-bm="Utama">Dashboard</a>
            </li>
            <li>
                <a href="#" data-lang-en="Browse Cars" data-lang-bm="Cari Kereta">Browse Cars</a>
            </li>
            <li>
                <a href="#" data-lang-en="My Bookings" data-lang-bm="Tempahan Saya">My Bookings</a>
            </li>
            <li>
                <a href="#" data-lang-en="My Profile" data-lang-bm="Profil Saya">My Profile</a>
            </li>
        </ul>
        
        <div class="logout-user">
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" data-lang-en="Logout" data-lang-bm="Log Keluar">Logout</a>
        </div>
    </div>

    <div class="content-user">
        <div class="header-user">
            <h1 id="welcome-text" data-lang-en="Hello, Guest!" data-lang-bm="Hai, Tetamu!">Hello, Guest!</h1>
            <div class="controls-user">
                <button class="btn-user btn-sec" onclick="toggleLanguage()" id="lang-btn">EN</button>
                <button class="btn-user btn-pri" onclick="toggleDarkMode()" id="theme-btn">🌙 Dark Mode</button>
            </div>
        </div>

        <div class="grid-user">
            <div class="card-user">
                <h3 data-lang-en="Current Rental" data-lang-bm="Sewa Aktif">Current Rental</h3>
                <p>1</p>
            </div>
            <div class="card-user">
                <h3 data-lang-en="Total Bookings" data-lang-bm="Jumlah Tempahan">Total Bookings</h3>
                <p>4</p>
            </div>
            <div class="card-user">
                <h3 data-lang-en="Member Points" data-lang-bm="Mata Ganjaran">Member Points</h3>
                <p class="points-highlight">250 XP</p>
            </div>
        </div>

        <div class="table-user-section">
            <h2 data-lang-en="Recent Bookings" data-lang-bm="Tempahan Terkini">Recent Bookings</h2>
            <div class="table-responsive">
                <table class="table-user">
                    <thead>
                        <tr>
                            <th data-lang-en="Car" data-lang-bm="Kereta">Car</th>
                            <th data-lang-en="Plate No." data-lang-bm="No. Plat">Plate No.</th>
                            <th data-lang-en="Rent Date" data-lang-bm="Tarikh Sewa">Rent Date</th>
                            <th data-lang-en="Status" data-lang-bm="Status">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="car-name">Honda Civic VTEC</td>
                            <td class="plate-number">VEM 9922</td>
                            <td>14 Jul 2026</td>
                            <td>
                                <span class="badge-user badge-active" data-lang-en="Active" data-lang-bm="Aktif">Active</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Fungsi Tukar Tema (Dark / Light Mode)
    function toggleDarkMode() {
        const html = document.documentElement;
        const themeBtn = document.getElementById('theme-btn');
        
        if (html.getAttribute('data-theme') === 'dark') {
            html.setAttribute('data-theme', 'light');
            themeBtn.innerHTML = '☀️ Light Mode';
        } else {
            html.setAttribute('data-theme', 'dark');
            themeBtn.innerHTML = '🌙 Dark Mode';
        }
    }

    // 2. Fungsi Tukar Bahasa Dinamik
    let currentLang = 'en';
    function toggleLanguage() {
        currentLang = currentLang === 'en' ? 'bm' : 'en';
        document.getElementById('lang-btn').innerText = currentLang === 'en' ? 'EN' : 'BM';
        
        document.querySelectorAll('[data-lang-en]').forEach(el => {
            el.textContent = currentLang === 'bm' ? el.getAttribute('data-lang-bm') : el.getAttribute('data-lang-en');
        });
    }
</script>

</body>
</html>