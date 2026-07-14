<div class="dashboard-wrapper">
    <h2>Selamat kembali, <?= h($user->name ?? $user->email) ?>!</h2>
    <p>Ini dashboard user anda.</p>

    <?= $this->Html->link('Log Keluar', ['action' => 'logout'], ['class' => 'btn-search']) ?>
</div>