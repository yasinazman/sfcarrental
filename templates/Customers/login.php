<?php
/**
 * @var \App\View\AppView $this
 */
// Paksa CakePHP untuk tidak menggunakan sebarang layout (termasuk sidebar admin)
$this->disableAutoLayout(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sfcarrental | Customer Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <?= $this->Html->css('customers-login') ?>
</head>
<body>

    <div class="top-controls">
        <a href="<?= $this->Url->build('/') ?>" class="control-btn" title="Back to Homepage">
            <i class="fa-solid fa-house"></i>
        </a>
        <button id="theme-toggle" class="control-btn" title="Toggle Theme">
            <i class="fa-solid fa-moon"></i>
        </button>
    </div>

    <div class="auth-container">
        <div class="auth-card">
            
            <div class="auth-header">
                <h2>SF <span style="color: var(--primary-red);">Car Rental</span></h2>
                <p data-en="Customer Login Portal" data-bm="Portal Log Masuk Pelanggan">Customer Login Portal</p>
            </div>

            <div class="live-timer-box">
                <div class="timer-item">
                    <i class="fa-regular fa-clock" style="color: var(--primary-red);"></i>
                    <span id="live-time">00:00:00 AM</span>
                </div>
                <div style="border-left: 1px solid var(--border-color); height: 14px;"></div>
                <div class="timer-item">
                    <i class="fa-regular fa-calendar" style="color: var(--primary-red);"></i>
                    <span id="live-date">Thursday, 16 July 2026</span>
                </div>
            </div>

            <?= $this->Flash->render() ?>

            <?= $this->Form->create(null, ['url' => ['controller' => 'Customers', 'action' => 'login']]) ?>
                <div class="form-group">
                    <label>
                        <i class="fa-solid fa-phone" style="color: var(--primary-red); margin-right: 5px;"></i> 
                        <span data-en="Phone Number" data-bm="Nombor Telefon">Phone Number</span>
                    </label>
                    <?= $this->Form->control('phone_number', [
                        'label' => false,
                        'required' => true,
                        'type' => 'text',
                        'placeholder' => 'e.g., +60123456789',
                    ]) ?>
                </div>

                <div class="form-group last-input">
                    <label>
                        <i class="fa-solid fa-lock" style="color: var(--primary-red); margin-right: 5px;"></i> 
                        <span data-en="Password" data-bm="Kata Laluan">Password</span>
                    </label>
                    <?= $this->Form->control('password', [
                        'label' => false,
                        'required' => true,
                        'type' => 'password',
                        'placeholder' => 'Enter password',
                    ]) ?>
                </div>

                <button type="submit" class="btn-auth-submit">
                    Login
                </button>
            <?= $this->Form->end() ?>

            <div class="auth-footer" style="margin-top: 25px; border-top: 1px solid var(--border-color); padding-top: 20px;">
                <p style="margin: 0;">
                    <span data-en="Don't have an account?" data-bm="Belum mempunyai akaun?">Don't have an account?</span> 
                    <br>
                    <a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'add']) ?>" data-en="Register Here" data-bm="Daftar Di Sini" style="display: inline-block; margin-top: 6px;">
                        Register Here
                    </a>
                </p>
            </div>

        </div>
    </div>

    <script>
        // --- LOGIK LIVE TIME & DATE ---
        function updateClock() {
            const now = new Date();
            
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let seconds = now.getSeconds();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            minutes = minutes < 10 ? '0'+minutes : minutes;
            seconds = seconds < 10 ? '0'+seconds : seconds;
            
            const timeString = `${hours}:${minutes}:${seconds} ${ampm}`;
            document.getElementById('live-time').textContent = timeString;

            const daysEn = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const daysBm = ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'];
            const monthsEn = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const monthsBm = ['Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'];

            const activeLang = localStorage.getItem('theme-lang') || 'en'; 

            const day = activeLang === 'en' ? daysEn[now.getDay()] : daysBm[now.getDay()];
            const date = now.getDate();
            const month = activeLang === 'en' ? monthsEn[now.getMonth()] : monthsBm[now.getMonth()];
            const year = now.getFullYear();

            const dateString = `${day}, ${date} ${month} ${year}`;
            document.getElementById('live-date').textContent = dateString;
        }

        setInterval(updateClock, 1000);
        updateClock();

        // --- LOGIK TEMA (DARK/LIGHT MODE) ---
        const themeToggle = document.getElementById('theme-toggle');
        
        function updateButtonIcon(theme) {
            if (theme === 'dark') {
                themeToggle.innerHTML = '<i class="fa-solid fa-sun"></i>';
                themeToggle.title = "Switch to Light Mode";
            } else {
                themeToggle.innerHTML = '<i class="fa-solid fa-moon"></i>';
                themeToggle.title = "Switch to Dark Mode";
            }
        }

        const currentTheme = localStorage.getItem('theme') || 'dark';
        if (currentTheme === 'light') {
            document.body.classList.add('light-theme');
            updateButtonIcon('light');
        } else {
            updateButtonIcon('dark');
        }

        themeToggle.addEventListener('click', () => {
            const isLight = document.body.classList.toggle('light-theme');
            const newTheme = isLight ? 'light' : 'dark';
            localStorage.setItem('theme', newTheme);
            updateButtonIcon(newTheme);
        });

        // --- SYNC BAHASA DARI HOMEPAGE ---
        const activeLang = localStorage.getItem('theme-lang') || 'en';
        document.querySelectorAll('[data-en]').forEach(element => {
            element.innerHTML = activeLang === 'en' ? element.getAttribute('data-en') : element.getAttribute('data-bm');
        });
    </script>
</body>
</html>