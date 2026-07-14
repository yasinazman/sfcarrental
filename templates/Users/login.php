<div class="signin-page-wrapper">
    <div class="signin-card">
        <h2>Log Masuk / Daftar</h2>

        <div class="auth-tabs">
            <button class="auth-tab active" data-target="login-form">Log Masuk</button>
            <button class="auth-tab" data-target="register-form">Daftar Akaun</button>
        </div>

        <!-- LOGIN FORM -->
        <div id="login-form" class="auth-panel active">
            <?= $this->Form->create() ?>
                <?= $this->Form->control('email', ['label' => 'Email']) ?>
                <?= $this->Form->control('password', ['label' => 'Kata Laluan']) ?>
                <?= $this->Form->button('Log Masuk', ['class' => 'btn-search']) ?>
            <?= $this->Form->end() ?>
        </div>

        <!-- REGISTER FORM -->
        <div id="register-form" class="auth-panel">
            <?= $this->Form->create($user, ['url' => ['action' => 'register']]) ?>
                <?= $this->Form->control('name', ['label' => 'Nama Penuh']) ?>
                <?= $this->Form->control('email', ['label' => 'Email']) ?>
                <?= $this->Form->control('password', ['label' => 'Kata Laluan']) ?>
                <?= $this->Form->button('Daftar', ['class' => 'btn-search']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.auth-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.auth-panel').forEach(p => p.classList.remove('active'));
        tab.classList.add('active');
        document.getElementById(tab.dataset.target).classList.add('active');
    });
});
</script>