<?php echo $this->Html->css('user-dashboard'); ?>
<div class="user-dashboard-wrapper">
    <!-- Copy-paste kod Sidebar dari dashboard.php di sini supaya menu kekal di kiri -->
    
    <div class="content-user">
        <div class="header-user">
            <h1 data-lang-en="Available Cars" data-lang-bm="Kereta Tersedia">Available Cars</h1>
        </div>
        
        <div class="grid-user">
            <?php if (!empty($cars)): ?>
                <?php foreach ($cars as $car): ?>
                    <div class="card-user" style="border-left: 4px solid var(--primary-user);">
                        <h3 class="plate-number"><?= h($car->plate_number) ?></h3>
                        <p class="car-name" style="font-size: 20px; margin-bottom: 10px;"><?= h($car->car_model) ?></p>
                        <div style="font-size: 14px; color: var(--text-muted-user);">
                            Rate: RM <?= number_format($car->price_per_day, 2) ?> / Day
                        </div>
                        <a href="#" class="btn-user btn-pri" style="display: block; text-align: center; margin-top: 15px; text-decoration: none;">Book Now</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: var(--text-muted-user);">No cars available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>