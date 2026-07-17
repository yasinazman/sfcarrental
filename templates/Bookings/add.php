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
</style>

<div class="booking-full-page">
    <div class="booking-grid">
        <!-- Kiri: Borang Tempahan -->
        <div style="background: #1e1e1e; padding: 30px; border-radius: 12px; border: 1px solid #333;">
            <h2 style="color: #e50914; margin-top: 0; border-bottom: 2px solid #e50914; padding-bottom: 10px;">New Car Booking</h2>
            
            <?= $this->Form->create($booking) ?>
                <?= $this->Form->control('car_id', ['value' => $car->id, 'type' => 'hidden']) ?>
                
                <div style="margin-bottom: 25px;">
                    <label style="font-weight: bold; margin-bottom: 10px; display: block; color: #fff;">Pick-up & Return Date</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <?= $this->Form->control('start_date', [
                            'type' => 'datetime-local', 
                            'label' => false, 
                            'value' => $booking->start_date,
                            'style' => 'width:100%; padding:15px; background:#2d2d2d; color:#fff; border:1px solid #444; border-radius:8px;'
                        ]) ?>
                        <?= $this->Form->control('end_date', [
                            'type' => 'datetime-local', 
                            'label' => false, 
                            'value' => $booking->end_date,
                            'style' => 'width:100%; padding:15px; background:#2d2d2d; color:#fff; border:1px solid #444; border-radius:8px;'
                        ]) ?>
                    </div>
                </div>

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
            <p style="color: #ddd;"><strong>Car:</strong> <?= h($car->brand) ?> <?= h($car->model) ?></p>
            <p style="color: #ddd;"><strong>Daily Rate:</strong> RM <?= number_format((float)$car->daily_rate, 2) ?></p>
            
            <div style="margin-top: 30px; padding: 15px; background: #2d2d2d; border-radius: 8px;">
                <p style="font-size: 0.85em; color: #aaa; margin: 0;">
                    * Sila semak semula butiran sebelum menekan butang bayaran. Tempahan anda akan terus diproses ke gerbang pembayaran selepas pengesahan.
                </p>
            </div>
        </div>
    </div>
</div>