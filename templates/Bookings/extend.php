<?php
/**
 * Halaman Extend Tempahan
 */
// 1. INI RAHSIA DIA: Kita panggil CSS Dashboard yang dah sedia 'center' dan full-width!
$this->Html->css('customers-dashboard', ['block' => true]);
?>

<style>
    /* 2. Design khas untuk kotak Extend Rental (duduk dalam dashboard-wrapper) */
    .extend-rental-card {
        background-color: #1e1e1e; 
        border: 1px solid #333; 
        border-radius: 12px; 
        padding: 40px; 
        box-shadow: 0 8px 24px rgba(0,0,0,0.5); 
        color: #ffffff;
        width: 100%;
        max-width: 900px;
        margin: 40px auto; /* Duduk santai di tengah */
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .extend-header {
        font-size: 28px; 
        font-weight: 700; 
        margin-bottom: 30px; 
        display: flex; 
        align-items: center; 
        gap: 12px;
    }

    .info-box { 
        background-color: #2a2a2a; 
        padding: 25px; 
        border-radius: 10px; 
        margin-bottom: 30px; 
        border-left: 4px solid #e50914; 
    }
    
    .info-box p { margin: 0 0 12px 0; color: #bbb; font-size: 16px; }
    .info-box p:last-child { margin: 0; }
    .info-box span { color: #fff; font-weight: 600; }
    .info-box span.rate { color: #28a745; }

    .form-group label { 
        font-weight: 600; 
        display: block; 
        margin-bottom: 10px; 
        color: #ddd; 
        font-size: 16px; 
    }
    
    .form-control-dark { 
        width: 100%; 
        max-width: 500px; 
        padding: 15px; 
        border-radius: 8px; 
        border: 1px solid #444; 
        background-color: #2a2a2a; 
        color: #fff; 
        font-size: 16px; 
        outline: none; 
    }
    
    .form-control-dark:focus { border-color: #e50914; }
    
    .warning-text { color: #e50914; display: block; margin-top: 10px; font-size: 14px; }

    .btn-action-group { 
        display: flex; 
        justify-content: flex-end; 
        gap: 15px; 
        margin-top: 40px; 
        border-top: 1px solid #333; 
        padding-top: 30px; 
    }
    
    .btn-cancel { 
        background-color: #333; 
        color: #ccc; 
        padding: 15px 25px; 
        border-radius: 8px; 
        text-decoration: none; 
        font-weight: 600; 
        font-size: 16px; 
        transition: background 0.2s; 
    }
    
    .btn-cancel:hover { background-color: #444; color: #fff; }
    
    .btn-submit-merah { 
        background-color: #e50914; 
        color: #ffffff; 
        padding: 15px 30px; 
        border: none; 
        border-radius: 8px; 
        font-weight: 700; 
        font-size: 16px; 
        cursor: pointer; 
        transition: background 0.3s; 
    }
    
    .btn-submit-merah:hover { background-color: #b20710; }
</style>

<!-- 3. KITA GUNA WRAPPER YANG SAMA DENGAN DASHBOARD -->
<div class="dashboard-wrapper">
    
    <div class="extend-rental-card">
        <div class="extend-header">
            <i class="fa-solid fa-clock-rotate-left" style="color: #e50914;"></i> Extend Rental
        </div>
        
        <div class="info-box">
            <p><strong>Car Model:</strong> <span><?= h($booking->car->car_model) ?></span></p>
            <p><strong>Plate Number:</strong> <span><?= h($booking->car->plate_number ?? 'N/A') ?></span></p>
            <p><strong>Current Return Date:</strong> <span><?= h($booking->end_date->format('d/m/Y h:i A')) ?></span></p>
            <p><strong>Daily Rate:</strong> <span class="rate">RM <?= number_format((float)$booking->rental_price, 2) ?> / day</span></p>
        </div>

        <form action="<?= $this->Url->build(['controller' => 'Bookings', 'action' => 'extend', $booking->id]) ?>" method="POST">
            <input type="hidden" name="_csrfToken" value="<?= $this->request->getAttribute('csrfToken') ?>">

            <div class="form-group">
                <label>Select New Return Date & Time</label>
                <input type="datetime-local" name="new_end_date" required 
                       min="<?= $booking->end_date->format('Y-m-d\TH:i') ?>" 
                       class="form-control-dark">
                
                <small class="warning-text">
                    <i class="fa-solid fa-triangle-exclamation"></i> Additional charges will apply based on the daily rate.
                </small>
            </div>

            <div class="btn-action-group">
                <a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'dashboard']) ?>" class="btn-cancel">
                    Cancel
                </a>
                
                <button type="submit" class="btn-submit-merah">
                    Proceed to Payment <i class="fa-solid fa-arrow-right" style="margin-left: 5px;"></i>
                </button>
            </div>
        </form>
    </div>
    
</div>