<?php
/**
 * @var \App\View\AppView $this
 */
// Panggil CSS user-register dari webroot/css/user-register.css
echo $this->Html->css('user-register'); 
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-lang-en="Register - SFCARRENTAL" data-lang-bm="Daftar Akaun - SFCARRENTAL">Register - SFCARRENTAL</title>
</head>
<body>

    <div class="top-controls">
        <div class="live-datetime">
            <span id="live-date">--/--/----</span>
            <span class="separator">|</span>
            <span id="live-time">00:00:00</span>
        </div>
        <div class="action-buttons">
            <button class="ctrl-btn" onclick="toggleLanguage()" id="lang-btn">EN</button>
            <button class="ctrl-btn" onclick="toggleTheme()" id="theme-btn">🌙</button>
        </div>
    </div>

    <div class="register-container">
        <div class="brand" data-lang-en="REGISTER SFCARRENTAL" data-lang-bm="DAFTAR SFCARRENTAL">REGISTER SFCARRENTAL</div>
        
        <?= $this->Flash->render() ?>

        <?= $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'Users', 'action' => 'register']]) ?>
            
            <div class="form-group">
                <label data-lang-en="Full Name (As in IC)" data-lang-bm="Nama Penuh (Seperti dalam IC)">Full Name (As in IC)</label>
                <?= $this->Form->control('full_name', [
                    'type' => 'text',
                    'id' => 'full_name',
                    'label' => false,
                    'placeholder' => 'Enter full name',
                    'required' => true
                ]) ?>
            </div>
            
            <div class="form-group">
                <label data-lang-en="Phone Number" data-lang-bm="Nombor Telefon">Phone Number</label>
                <?= $this->Form->control('phone', [
                    'type' => 'text',
                    'id' => 'phone',
                    'label' => false,
                    'placeholder' => 'e.g. 0123456789',
                    'required' => true
                ]) ?>
            </div>
            
            <div class="form-group">
                <label data-lang-en="Password" data-lang-bm="Kata Laluan">Password</label>
                <?= $this->Form->control('password', [
                    'type' => 'password',
                    'id' => 'password',
                    'label' => false,
                    'placeholder' => 'Create password',
                    'required' => true
                ]) ?>
            </div>
            
            <div class="form-group">
                <label data-lang-en="IC Image (Front)" data-lang-bm="Gambar IC (Depan)">IC Image (Front)</label>
                <?= $this->Form->control('ic_front', [
                    'type' => 'file',
                    'label' => false,
                    'accept' => 'image/*',
                    'required' => true
                ]) ?>
            </div>
            
            <div class="form-group">
                <label data-lang-en="IC Image (Back)" data-lang-bm="Gambar IC (Belakang)">IC Image (Back)</label>
                <?= $this->Form->control('ic_back', [
                    'type' => 'file',
                    'label' => false,
                    'accept' => 'image/*',
                    'required' => true
                ]) ?>
            </div>
            
            <div class="form-group">
                <label data-lang-en="Driving License" data-lang-bm="Gambar Lesen Memandu">Driving License</label>
                <?= $this->Form->control('license', [
                    'type' => 'file',
                    'label' => false,
                    'accept' => 'image/*',
                    'required' => true
                ]) ?>
            </div>
            
            <button type="submit" class="btn-register" data-lang-en="REGISTER NOW" data-lang-bm="DAFTAR SEKARANG">REGISTER NOW</button>
            
            <div class="form-footer">
                <span data-lang-en="Already have an account? " data-lang-bm="Dah ada akaun? ">Already have an account? </span>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" data-lang-en="Login here" data-lang-bm="Login sini">Login here</a>
            </div>
        <?= $this->Form->end() ?>
    </div>

    <script>
        // 1. Fungsi Jam & Tarikh Berjalan (Real-time)
        function updateDateTime() {
            const now = new Date();
            const options = { day: '2-digit', month: 'short', year: 'numeric' };
            document.getElementById('live-date').innerText = now.toLocaleDateString('en-GB', options);
            document.getElementById('live-time').innerText = now.toTimeString().split(' ')[0];
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();

        // 2. Fungsi Tukar Bahasa (EN / BM)
        let currentLang = 'en';
        const langPlaceholders = {
            en: { 
                full_name: 'Enter full name', 
                phone: 'e.g. 0123456789', 
                password: 'Create password' 
            },
            bm: { 
                full_name: 'Masukkan nama penuh', 
                phone: 'Contoh: 0123456789', 
                password: 'Cipta kata laluan' 
            }
        };

        function toggleLanguage() {
            currentLang = currentLang === 'en' ? 'bm' : 'en';
            document.getElementById('lang-btn').innerText = currentLang === 'en' ? 'EN' : 'BM';
            
            // Tukar semua teks statik yang ada attribute data-lang
            document.querySelectorAll('[data-lang-en]').forEach(el => {
                el.innerText = currentLang === 'en' ? el.getAttribute('data-lang-en') : el.getAttribute('data-lang-bm');
            });

            // Kemas kini placeholder input form
            document.getElementById('full_name').setAttribute('placeholder', langPlaceholders[currentLang].full_name);
            document.getElementById('phone').setAttribute('placeholder', langPlaceholders[currentLang].phone);
            document.getElementById('password').setAttribute('placeholder', langPlaceholders[currentLang].password);
        }

        // 3. Fungsi Tukar Tema (Dark / Light Mode)
        function toggleTheme() {
            const html = document.documentElement;
            const themeBtn = document.getElementById('theme-btn');
            
            if (html.getAttribute('data-theme') === 'dark') {
                html.setAttribute('data-theme', 'light');
                themeBtn.innerText = '☀️';
            } else {
                html.setAttribute('data-theme', 'dark');
                themeBtn.innerText = '🌙';
            }
        }
    </script>
</body>
</html>