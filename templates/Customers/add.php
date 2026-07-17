<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sfcarrental | Register Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <?= $this->Html->css('customers-add') ?>
</head>
<body>

<div class="top-nav-buttons">
    <a href="<?= $this->Url->build('/') ?>" class="nav-btn"><i class="fa-solid fa-house"></i> Home</a>
    <button id="theme-toggle" class="nav-btn"><i class="fa-solid fa-moon"></i> Theme</button>
</div>

<div class="auth-container register">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Register <span style="color: var(--primary-red);">Account</span></h2>
            <p>Join sfcarrental and start booking your favorite ride.</p>
        </div>

        <!-- Live Timer Box Ditambah -->
        <div class="live-timer-box">
            <div class="timer-item"><i class="fa-regular fa-clock" style="color: var(--primary-red);"></i> <span id="live-time">00:00:00 AM</span></div>
            <div style="border-left: 1px solid var(--border-color); height: 14px;"></div>
            <div class="timer-item"><i class="fa-regular fa-calendar" style="color: var(--primary-red);"></i> <span id="live-date">...</span></div>
        </div>

        <?= $this->Flash->render() ?>
        <?= $this->Form->create($customer, ['type' => 'file', 'id' => 'registerForm']) ?>
            <div class="form-grid">
                <div class="col-left">
                    <div class="form-group">
                        <label>Full Name</label>
                        <?= $this->Form->control('full_name', ['label' => false, 'required' => true, 'placeholder' => 'Enter your full name']) ?>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <?= $this->Form->control('phone_number', ['label' => false, 'required' => true, 'type' => 'tel', 'placeholder' => '0123456789']) ?>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <?= $this->Form->control('password', ['label' => false, 'required' => true, 'placeholder' => 'Create a secure password']) ?>
                    </div>
                </div>
                <div class="col-right">
                    <div class="form-group">
                        <label>IC Front Photo *</label>
                        <?= $this->Form->control('ic_file', ['type' => 'file', 'label' => false, 'required' => true]) ?>
                    </div>
                    <div class="form-group">
                        <label>IC Back Photo (Optional)</label>
                        <?= $this->Form->control('ic_back_file', ['type' => 'file', 'label' => false, 'required' => false]) ?>
                    </div>
                    <div class="form-group">
                        <label>Driving License Photo *</label>
                        <?= $this->Form->control('license_file', ['type' => 'file', 'label' => false, 'required' => true]) ?>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-auth-submit">Create Account</button>
        <?= $this->Form->end() ?>

        <div class="auth-footer">
            <p>Already have an account? <a href="<?= $this->Url->build(['action' => 'login']) ?>">Sign In here</a></p>
        </div>
    </div>
</div>

<script>
    // Live Timer
    function updateClock() {
        const now = new Date();
        document.getElementById('live-time').textContent = now.toLocaleTimeString();
        document.getElementById('live-date').textContent = now.toDateString();
    }
    setInterval(updateClock, 1000); updateClock();

    // Theme Toggle
    const themeToggle = document.getElementById('theme-toggle');
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('light-theme');
        localStorage.setItem('theme', document.body.classList.contains('light-theme') ? 'light' : 'dark');
    });
    if(localStorage.getItem('theme') === 'light') document.body.classList.add('light-theme');
</script>
</body>
</html>