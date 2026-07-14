<?php
/**
 * @var \App\View\AppView $this
 */
echo $this->Html->css('user-login'); 
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-lang-en="Login - SFCARRENTAL" data-lang-bm="Log Masuk - SFCARRENTAL">Login - SFCARRENTAL</title>
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

    <div class="login-container">
        <div class="brand">SFCARRENTAL</div>

        <?= $this->Flash->render() ?>

        <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'login']]) ?>
            
            <div class="form-group">
                <label for="phone" data-lang-en="Phone Number" data-lang-bm="Nombor Telefon">Phone Number</label>
                <?= $this->Form->control('phone', [
                    'type' => 'text',
                    'id' => 'phone',
                    'label' => false,
                    'placeholder' => 'Contoh: 0123456789',
                    'required' => true
                ]) ?>
            </div>

            <div class="form-group">
                <label for="password" data-lang-en="Password" data-lang-bm="Kata Laluan">Password</label>
                <?= $this->Form->control('password', [
                    'type' => 'password',
                    'id' => 'password',
                    'label' => false,
                    'placeholder' => '••••••••',
                    'required' => true
                ]) ?>
            </div>

            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'dashboard']) ?>" class="btn-login" id="btn-submit-text" data-lang-en="LOG IN" data-lang-bm="LOG MASUK">
                LOG IN
            </a>
            
            <div class="form-footer">
                <span data-lang-en="Don't have an account? " data-lang-bm="Belum ada akaun? ">Don't have an account? </span>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'register']) ?>" data-lang-en="Register here" data-lang-bm="Daftar sini">Register here</a>
            </div>

        <?= $this->Form->end() ?>
    </div>

    <script>
        // 1. Real-time Clock & Date
        function updateDateTime() {
            const now = new Date();
            
            // Format Tarikh (DD MMM YYYY)
            const options = { day: '2-digit', month: 'short', year: 'numeric' };
            document.getElementById('live-date').innerText = now.toLocaleDateString('en-GB', options);
            
            // Format Jam (HH:MM:SS)
            document.getElementById('live-time').innerText = now.toTimeString().split(' ')[0];
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();

        // 2. Multi-language Toggle (EN | BM)
        let currentLang = 'en';
        const langPlaceholders = {
            en: { phone: 'e.g. 0123456789', password: 'Enter password' },
            bm: { phone: 'Contoh: 0123456789', password: 'Masukkan kata laluan' }
        };

        function toggleLanguage() {
            currentLang = currentLang === 'en' ? 'bm' : 'en';
            document.getElementById('lang-btn').innerText = currentLang === 'en' ? 'EN' : 'BM';
            
            // Tukar semua text elemen yang mempunyai data-lang
            document.querySelectorAll('[data-lang-en]').forEach(el => {
                el.innerText = currentLang === 'en' ? el.getAttribute('data-lang-en') : el.getAttribute('data-lang-bm');
            });

            // Tukar placeholder input CakePHP
            document.getElementById('phone').setAttribute('placeholder', langPlaceholders[currentLang].phone);
            document.getElementById('password').setAttribute('placeholder', langPlaceholders[currentLang].password);
        }

        // 3. Dark / Light Theme Toggle
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