
<div class="full-width-page">
    <h2 class="section-title">Available Cars for your trip</h2>
    
</div>

<style>
    /* Paksa supaya booking form tidak menutup content atau mengehadkan lebar */
    .booking-form-container {
        position: relative !important; /* Tukar dari fixed ke relative */
        width: 100% !important;
        max-width: 100% !important;
        height: auto !important;
        border-radius: 0 !important;
        padding: 20px !important;
    }

    /* Paksa container supaya penuh 100% */
    .navbar, .hero-container, .top-bar-container {
        max-width: 100% !important;
        padding-left: 40px !important;
        padding-right: 40px !important;
    }

    /* Hilangkan padding kiri body yang dikhaskan untuk sidebar fixed */
    @media (min-width: 993px) {
        body { padding-left: 0 !important; }
    }
</style>

    <!-- Senarai Kereta (Grid) -->
    <div class="cars-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
    <?php if (!empty($cars)): ?>
        <?php foreach ($cars as $car): ?>
            <div class="car-card" style="border: 1px solid #333; padding: 15px; border-radius: 8px;">
    <!-- Pastikan fail gambar ada dalam webroot/img/cars/ -->
    <img src="<?= $this->Url->webroot('img/cars/' . $car->image) ?>" alt="Car Image" style="width: 100%; height: 200px; object-fit: cover;">
    
    <h3><?= h($car->car_model) ?></h3> 
    <p>Harga: RM <?= number_format((float)$car->daily_rate, 2) ?> / hari</p>
    
    <?= $this->Html->link('Select This Car', [
    'controller' => 'Bookings', 
    'action' => 'add', 
    $car->id, 
    '?' => [ // Data ini akan dibawa ke URL
        'start_date' => $this->request->getQuery('start_date'),
        'end_date' => $this->request->getQuery('end_date')
    ]
], ['class' => 'btn-select']) ?>
</div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Tiada kereta ditemui untuk carian ini.</p>
    <?php endif; ?>
</div>
    </div>
</div>