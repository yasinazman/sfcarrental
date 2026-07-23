<style>
    /* Paksa layout asal supaya tidak ada padding/margin yang menyekat */
    body, .main-content-wrapper, .container, .page-wrapper {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    
    /* ========================================================
       TEMA CERAH (LIGHT MODE) - Default
       ======================================================== */
    .booking-full-page {
        width: 100%;
        min-height: 100vh;
        background-color: #f4f7f6;
        padding: 40px;
        box-sizing: border-box;
        transition: background-color 0.3s ease;
    }

    .booking-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 30px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .panel-box {
        background: #ffffff;
        padding: 30px;
        border-radius: 12px;
        border: 1px solid #ddd;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .form-grid-row {
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 20px;
        margin-bottom: 20px;
    }

    .input-label {
        color: #333;
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
        transition: color 0.3s ease;
    }

    .input-field {
        width: 100%;
        padding: 15px;
        background: #fff;
        color: #333;
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }
    
    /* Readonly field */
    .input-field[readonly] {
        background: #eee;
        color: #666;
        cursor: not-allowed;
    }

    .summary-text {
        color: #555;
        margin: 8px 0;
        transition: color 0.3s ease;
    }
    
    .plate-badge {
        background: #fdc500;
        color: #000;
        padding: 2px 10px;
        border-radius: 4px;
        font-weight: 800;
        letter-spacing: 1px;
        font-size: 0.9em;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .summary-note {
        margin-top: 30px;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 8px;
        font-size: 0.85em;
        color: #666;
    }

    .total-price {
        color: #000;
        font-size: 1.2em;
        margin: 15px 0 10px 0;
    }

    /* ========================================================
       TEMA GELAP (DARK MODE) - Dipanggil oleh script default.php
       ======================================================== */
    body.dark-theme .booking-full-page {
        background-color: #121212;
    }

    body.dark-theme .panel-box {
        background: #1e1e1e;
        border: 1px solid #333;
    }

    body.dark-theme .input-label {
        color: #fff;
    }

    body.dark-theme .input-field {
        background: #2d2d2d;
        color: #fff;
        border: 1px solid #444;
    }
    
    body.dark-theme .input-field[readonly] {
        background: #1a1a1a;
        color: #888;
    }

    body.dark-theme .summary-text {
        color: #ddd;
    }

    body.dark-theme .summary-note {
        background: #2d2d2d;
        color: #aaa;
    }

    body.dark-theme .total-price {
        color: #fff;
    }
</style>

<div class="booking-full-page">
    <div class="booking-grid">
        <!-- Kiri: Borang Tempahan Seiras Dashboard -->
        <div class="panel-box">
            <h2 style="color: #e50914; margin-top: 0; border-bottom: 2px solid #e50914; padding-bottom: 10px;">Detailed Booking</h2>
            
            <?= $this->Form->create($booking) ?>
                <?= $this->Form->control('car_id', ['value' => $car->id, 'type' => 'hidden']) ?>
                
                <!-- Baris 1: Where to & Vehicle Class -->
                <div class="form-grid-row">
                    <div>
                        <?= $this->Form->control('destination', [
                            'label' => ['text' => 'Where to?', 'class' => 'input-label'],
                            'value' => $booking->destination,
                            'class' => 'input-field',
                            'placeholder' => 'Genting Highlands...',
                            'required' => true
                        ]) ?>
                    </div>
                    <div>
                        <label class="input-label">Vehicle Class</label>
                        <input type="text" value="<?= h($car->category ?? $car->car_category ?? 'Selected Class') ?>" readonly class="input-field">
                    </div>
                </div>

                <!-- Baris 2: Pick-up Date & Return Date -->
                <div class="form-grid-row">
                    <div>
                        <label class="input-label">Pick-up Date</label>
                        <?= $this->Form->control('start_date', [
                            'type' => 'datetime-local', 
                            'label' => false, 
                            'value' => $booking->start_date,
                            'class' => 'input-field',
                            'required' => true
                        ]) ?>
                    </div>
                    <div>
                        <label class="input-label">Return Date</label>
                        <?= $this->Form->control('end_date', [
                            'type' => 'datetime-local', 
                            'label' => false, 
                            'value' => $booking->end_date,
                            'class' => 'input-field',
                            'required' => true
                        ]) ?>
                    </div>
                </div>

                <!-- Baris 3: Pickup Location & Drop Off Location -->
                <div class="form-grid-row">
                    <div>
                        <?= $this->Form->control('pickup_location', [
                            'type' => 'select',
                            'options' => [
                                'SF HQ' => 'SF Car Rental HQ',
                                'I-CITY' => 'I-City Shah Alam',
                                'AEON' => 'AEON Mall Shah Alam'
                            ],
                            'empty' => 'Select Location...',
                            'value' => $booking->pickup_location,
                            'label' => ['text' => 'Pickup Location', 'class' => 'input-label'],
                            'class' => 'input-field',
                            'required' => true
                        ]) ?>
                    </div>
                    <div>
                        <?= $this->Form->control('dropoff_location', [
                            'type' => 'select',
                            'options' => [
                                'SF HQ' => 'SF Car Rental HQ',
                                'I-CITY' => 'I-City Shah Alam',
                                'AEON' => 'AEON Mall Shah Alam'
                            ],
                            'empty' => 'Select Location...',
                            'value' => $booking->dropoff_location,
                            'label' => ['text' => 'Drop Off Location', 'class' => 'input-label'],
                            'class' => 'input-field',
                            'required' => true
                        ]) ?>
                    </div>
                </div>
                
                <div style="margin-top: 25px;">
                    <?= $this->Form->button(__('Confirm & Proceed to Payment'), [
                        'style' => 'width: 100%; background: #e50914; color: white; padding: 18px; border: none; font-size: 16px; font-weight: bold; cursor: pointer; border-radius: 8px;'
                    ]) ?>
                </div>
            <?= $this->Form->end() ?>
        </div>

        <!-- Kanan: Summary -->
        <div class="panel-box" style="height: fit-content;">
            <h3 style="margin-top: 0; color: #e50914; border-bottom: 1px solid #ddd; padding-bottom: 10px;">Booking Summary</h3>
            
            <div style="line-height: 1.8;">
                <p class="summary-text" style="font-size: 1.1em;"><strong>Car:</strong> <?= h($car->car_model) ?></p>
                <p class="summary-text"><strong>Plate Number:</strong> <span class="plate-badge"><?= h($car->plate_number ?? 'N/A') ?></span></p>
                <p class="summary-text"><strong>Specs:</strong> <?= h($car->transmission ?? 'Auto') ?> &bull; <?= h($car->seat_capacity ?? 5) ?> Seats</p>
                <p class="summary-text"><strong>Daily Rate:</strong> RM <?= number_format((float)$car->daily_rate, 2) ?></p>
                
                <?php if ($totalDays > 0): ?>
                    <hr style="border: 0; border-top: 1px solid #ddd; margin: 15px 0;">
                    <p class="summary-text"><strong>Duration:</strong> <?= $totalDays ?> Days</p>
                    <p class="total-price"><strong>Total Rental: RM <?= number_format($totalPrice, 2) ?></strong></p>
                    <div style="background: rgba(229, 9, 20, 0.1); padding: 10px 15px; border-radius: 6px; border-left: 4px solid #e50914; margin-top: 15px;">
                        <p style="margin: 0; color: #e50914; font-weight: bold; font-size: 1.1em;">
                            Total Payable: RM <?= number_format($totalPrice, 2) ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="summary-note">
                <p style="margin: 0;">
                    * Please double-check your dates carefully. The total rental price above is based on the selected duration. Full payment is required to secure your booking.
                </p>
            </div>
        </div>
    </div>
</div>