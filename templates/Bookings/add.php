<style>
    /* Paksa layout asal supaya tidak ada padding/margin yang menyekat */
    body, .main-content-wrapper, .container, .page-wrapper {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    
    /* Container utama yang memenuhi skrin */
    .booking-full-page {
        width: 100%;
        min-height: 100vh;
        background-color: #121212;
        padding: 40px;
        box-sizing: border-box;
    }

    /* Grid untuk memastikan borang dan summary seimbang */
    .booking-grid {
        display: grid;
        grid-template-columns: 1fr 400px; /* Borang lebih luas, summary tetap lebar */
        gap: 30px;
        max-width: 1400px; /* Lebar maksimum yang selesa untuk mata */
        margin: 0 auto;
    }

    .form-grid-row {
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 20px;
        margin-bottom: 20px;
    }
</style>

<div class="booking-full-page">
    <div class="booking-grid">
        <!-- Kiri: Borang Tempahan Seiras Dashboard -->
        <div style="background: #1e1e1e; padding: 30px; border-radius: 12px; border: 1px solid #333;">
            <h2 style="color: #e50914; margin-top: 0; border-bottom: 2px solid #e50914; padding-bottom: 10px;">Detailed Booking</h2>
            
            <?= $this->Form->create($booking) ?>
                <?= $this->Form->control('car_id', ['value' => $car->id, 'type' => 'hidden']) ?>
                
                <!-- Baris 1: Where to & Vehicle Class -->
                <div class="form-grid-row">
                    <div>
                        <?= $this->Form->control('destination', [
                            'label' => ['text' => 'Where to?', 'style' => 'color: #fff; font-weight: bold; margin-bottom: 10px; display: block;'],
                            'value' => $booking->destination, // Auto-isi nilai dari URL
                            'style' => 'width:100%; padding:15px; background:#2d2d2d; color:#fff; border:1px solid #444; border-radius:8px;',
                            'placeholder' => 'Genting Highlands...',
                            'required' => true
                        ]) ?>
                    </div>
                    <div>
                        <label style="color: #fff; font-weight: bold; margin-bottom: 10px; display: block;">Vehicle Class</label>
                        <input type="text" value="<?= h($car->category ?? $car->car_category ?? 'Selected Class') ?>" readonly style="width:100%; padding:15px; background:#1a1a1a; color:#888; border:1px solid #444; border-radius:8px; cursor: not-allowed;">
                    </div>
                </div>

                <!-- Baris 2: Pick-up Date & Return Date -->
                <div class="form-grid-row">
                    <div>
                        <label style="color: #fff; font-weight: bold; margin-bottom: 10px; display: block;">Pick-up Date</label>
                        <?= $this->Form->control('start_date', [
                            'type' => 'datetime-local', 
                            'label' => false, 
                            'value' => $booking->start_date, // Auto-isi nilai dari URL
                            'style' => 'width:100%; padding:15px; background:#2d2d2d; color:#fff; border:1px solid #444; border-radius:8px;',
                            'required' => true
                        ]) ?>
                    </div>
                    <div>
                        <label style="color: #fff; font-weight: bold; margin-bottom: 10px; display: block;">Return Date</label>
                        <?= $this->Form->control('end_date', [
                            'type' => 'datetime-local', 
                            'label' => false, 
                            'value' => $booking->end_date, // Auto-isi nilai dari URL
                            'style' => 'width:100%; padding:15px; background:#2d2d2d; color:#fff; border:1px solid #444; border-radius:8px;',
                            'required' => true
                        ]) ?>
                    </div>
                </div>

                <!-- Baris 3: Pickup Location & Drop Off Location -->
                <div class="form-grid-row">
                    <div>
                        <?= $this->Form->control('pickup_location', [
                            'type' => 'select',
                            // Samakan key dengan teks sebenar untuk pastikan auto-select berfungsi
                            'options' => [
                                'SF Car Rental HQ' => 'SF Car Rental HQ',
                                'I-City Shah Alam' => 'I-City Shah Alam',
                                'AEON Mall Shah Alam' => 'AEON Mall Shah Alam'
                            ],
                            'empty' => 'Select Location...',
                            'value' => $booking->pickup_location, // Auto-isi nilai dari URL
                            'label' => ['text' => 'Pickup Location', 'style' => 'color: #fff; font-weight: bold; margin-bottom: 10px; display: block;'],
                            'style' => 'width:100%; padding:15px; background:#2d2d2d; color:#fff; border:1px solid #444; border-radius:8px;',
                            'required' => true
                        ]) ?>
                    </div>
                    <div>
                        <?= $this->Form->control('dropoff_location', [
                            'type' => 'select',
                            'options' => [
                                'SF Car Rental HQ' => 'SF Car Rental HQ',
                                'I-City Shah Alam' => 'I-City Shah Alam',
                                'AEON Mall Shah Alam' => 'AEON Mall Shah Alam'
                            ],
                            'empty' => 'Select Location...',
                            'value' => $booking->dropoff_location, // Auto-isi nilai dari URL
                            'label' => ['text' => 'Drop Off Location', 'style' => 'color: #fff; font-weight: bold; margin-bottom: 10px; display: block;'],
                            'style' => 'width:100%; padding:15px; background:#2d2d2d; color:#fff; border:1px solid #444; border-radius:8px;',
                            'required' => true
                        ]) ?>
                    </div>
                </div>
                
                <!-- Deposit Amount -->
                <div style="margin-bottom: 25px;">
                    <?= $this->Form->control('deposit_amount', [
                        'label' => ['text' => 'Deposit Amount (RM)', 'style' => 'color: #fff; font-weight: bold; margin-bottom: 10px; display: block;'],
                        'style' => 'width:100%; padding:15px; background:#2d2d2d; color:#fff; border:1px solid #444; border-radius:8px;'
                    ]) ?>
                </div>
                
                <?= $this->Form->button(__('Confirm & Proceed to Payment'), [
                    'style' => 'width: 100%; background: #e50914; color: white; padding: 18px; border: none; font-size: 16px; font-weight: bold; cursor: pointer; border-radius: 8px;'
                ]) ?>
            <?= $this->Form->end() ?>
        </div>

        <!-- Kanan: Summary -->
        <div style="background: #1e1e1e; padding: 30px; border-radius: 12px; border: 1px solid #333; height: fit-content;">
            <h3 style="margin-top: 0; color: #e50914; border-bottom: 1px solid #333; padding-bottom: 10px;">Booking Summary</h3>
            
            <div style="line-height: 2;">
                <p style="color: #ddd; margin: 5px 0;"><strong>Car:</strong> <?= h($car->car_model) ?></p>
                <p style="color: #ddd; margin: 5px 0;"><strong>Daily Rate:</strong> RM <?= number_format((float)$car->daily_rate, 2) ?></p>
                
                <?php if ($totalDays > 0): ?>
                    <hr style="border: 0; border-top: 1px solid #333; margin: 15px 0;">
                    <p style="color: #ddd; margin: 5px 0;"><strong>Duration:</strong> <?= $totalDays ?> hari</p>
                    <p style="color: #fff; font-size: 1.2em; margin: 10px 0;"><strong>Total: RM <?= number_format($totalPrice, 2) ?></strong></p>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 30px; padding: 15px; background: #2d2d2d; border-radius: 8px;">
                <p style="font-size: 0.85em; color: #aaa; margin: 0;">
                    * Sila semak tarikh dengan teliti. Jumlah harga di atas adalah berdasarkan tempoh sewaan yang dipilih.
                </p>
            </div>
        </div>
    </div>
</div>