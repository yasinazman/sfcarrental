<!-- CSS Khas untuk halaman ini -->
<style>
    /* Reset margin supaya betul-betul full page */
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        width: 100%;
    }

    /* Flexbox untuk pastikan kotak sentiasa di tengah skrin */
    .full-page-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        width: 100%;
        background-color: #121212;
        padding: 20px;
        box-sizing: border-box;
    }

    .payment-card {
        width: 100%;
        max-width: 500px;
        background: #1e1e1e;
        padding: 30px;
        border-radius: 12px;
        border: 1px solid #333;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5);
    }
</style>

<!-- Struktur Full Page -->
<div class="full-page-wrapper">
    <div class="payment-card">
        
        <h2 style="color: #e50914; margin-top: 0;">Upload Payment Receipt</h2>
        <p style="color: #aaa; margin-bottom: 20px;">Please upload your bank transfer slip for Booking ID: #<?= h($booking->id) ?></p>
        
        <?= $this->Form->create($payment, ['type' => 'file']) ?>
            
            <div style="margin-bottom: 20px;">
                <?= $this->Form->control('payment_method', [
                    'options' => ['Bank Transfer' => 'Bank Transfer', 'E-Wallet' => 'E-Wallet'],
                    'label' => ['style' => 'font-weight: bold; margin-bottom: 10px; display: block; color: #fff;'],
                    'style' => 'width: 100%; padding: 12px; background: #2d2d2d; color: #fff; border: 1px solid #444; border-radius: 8px;'
                ]) ?>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="font-weight: bold; margin-bottom: 10px; display: block; color: #fff;">Upload Receipt Image (JPG/PNG):</label>
                <input type="file" name="receipt_file" style="width: 100%; padding: 10px; background: #2d2d2d; color: #fff; border: 1px solid #444; border-radius: 8px;" required>
            </div>
            
            <?= $this->Form->button('Submit Receipt', [
                'style' => 'width: 100%; background: #e50914; color: white; padding: 15px; border: none; font-weight: bold; cursor: pointer; border-radius: 8px;'
            ]) ?>
            
        <?= $this->Form->end() ?>
    </div>
</div>