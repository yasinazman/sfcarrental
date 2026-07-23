<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */

// Mapping Lokasi Automatik (Mengubah kod lokasi seperti SF HQ / I-CITY kepada nama penuh)
$locationMap = [
    'SF HQ' => 'SF Car Rental HQ',
    'I-CITY' => 'I-City Shah Alam',
    'AEON' => 'AEON Mall Shah Alam',
];

$pickupRaw = $payment->booking->pickup_location ?? '';
$dropoffRaw = $payment->booking->dropoff_location ?? '';

$pickupLocation = $locationMap[$pickupRaw] ?? (!empty($pickupRaw) ? $pickupRaw : 'SF Car Rental HQ');
$dropoffLocation = $locationMap[$dropoffRaw] ?? (!empty($dropoffRaw) ? $dropoffRaw : 'SF Car Rental HQ');

// Maklumat Kereta
$car = $payment->booking->car ?? null;
$carModel = $car->car_model ?? 'Vehicle Information N/A';
$plateNumber = $car->plate_number ?? 'N/A';
$transmission = $car->transmission ?? 'Auto';
$seats = $car->seat_capacity ?? 5;
?>

<style>
    /* ========================================================
       RESET & LAYOUT WEB
       ======================================================== */
    body, .main-content-wrapper, .container, .page-wrapper {
        max-width: 100% !important; padding: 0 !important; margin: 0 !important;
    }
    
    /* Sembunyikan layout print di web */
    .print-only-receipt { display: none; }

    /* Layout Web (Dark/Light Mode) */
    .receipt-full-page {
        width: 100%; min-height: 100vh; background-color: #f4f7f6;
        padding: 40px; box-sizing: border-box; transition: background-color 0.3s ease;
    }
    .receipt-grid {
        display: grid; grid-template-columns: 1fr 400px; gap: 30px;
        max-width: 1400px; margin: 0 auto;
    }
    .panel-box {
        background: #ffffff; padding: 30px; border-radius: 12px;
        border: 1px solid #ddd; box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .detail-grid-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .detail-label { color: #333; font-weight: bold; margin-bottom: 8px; display: block; font-size: 0.9em; text-transform: uppercase; letter-spacing: 0.5px; }
    .detail-value { width: 100%; padding: 15px; background: #ffffff; color: #333; border: 1px solid #ccc; border-radius: 8px; font-weight: 600; box-sizing: border-box; }
    
    .plate-badge {
        background: #fdc500;
        color: #000;
        padding: 3px 8px;
        border-radius: 4px;
        font-weight: 800;
        letter-spacing: 1px;
        font-size: 0.85em;
        margin-left: 8px;
    }

    .total-amount-box { background: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; }
    .total-amount-text { color: #28a745; font-size: 2em; font-weight: bold; margin: 5px 0 0 0; }
    .summary-note { margin-top: 25px; padding: 15px; background: #f9f9f9; border-radius: 8px; font-size: 0.85em; color: #666; line-height: 1.5; }
    .status-badge-paid { display: inline-block; background: #28a745; color: #ffffff; padding: 8px 18px; border-radius: 20px; font-size: 0.85em; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
    
    .btn-action-primary { width: 100%; background: #e50914; color: #ffffff !important; padding: 16px; border: none; font-size: 15px; font-weight: bold; cursor: pointer; border-radius: 8px; text-align: center; text-decoration: none; display: block; margin-bottom: 12px; box-sizing: border-box; }
    .btn-action-primary:hover { background: #b20710; }
    .btn-action-secondary { width: 100%; background: #333333; color: #ffffff !important; padding: 16px; border: none; font-size: 15px; font-weight: bold; cursor: pointer; border-radius: 8px; text-align: center; text-decoration: none; display: block; box-sizing: border-box; }
    .btn-action-secondary:hover { background: #444444; }

    /* ========================================================
       DARK MODE WEB
       ======================================================== */
    body.dark-theme .receipt-full-page { background-color: #121212; }
    body.dark-theme .panel-box { background: #1e1e1e; border: 1px solid #333; }
    body.dark-theme .detail-label { color: #ffffff; }
    body.dark-theme .detail-value { background: #2d2d2d; color: #ffffff; border: 1px solid #444; }
    body.dark-theme .summary-note { background: #2d2d2d; color: #aaa; }
    body.dark-theme .total-amount-box { background: rgba(40, 167, 69, 0.15); border-color: #28a745; }

    /* ========================================================
       PRINT OPTIMIZATION (INBOIS PROFESIONAL A4)
       ======================================================== */
    @media print {
        @page { size: A4; margin: 1.5cm; }
        
        body { background: #ffffff !important; }
        .receipt-full-page, header, nav, footer, .navbar, .top-bar, .message, .flash-message, .theme-btn-float { 
    display: none !important; 
}
        
        .print-only-receipt {
            display: block !important;
            width: 100%;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #000;
        }
        
        .print-header { display: flex; justify-content: space-between; border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 25px; }
        .print-logo h1 { margin: 0; color: #e50914 !important; font-size: 28px; text-transform: uppercase; }
        .print-logo p { margin: 3px 0 0 0; font-size: 12px; color: #555; }
        .print-title { text-align: right; }
        .print-title h2 { margin: 0; font-size: 24px; color: #333; text-transform: uppercase; }
        .print-title p { margin: 3px 0 0 0; font-weight: bold; color: #666; font-size: 13px; }
        
        .print-info-row { display: flex; justify-content: space-between; margin-bottom: 25px; }
        .print-info-box { width: 48%; }
        .print-info-box h4 { margin: 0 0 10px 0; font-size: 13px; color: #888; text-transform: uppercase; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .print-info-box p { margin: 6px 0; font-size: 13px; line-height: 1.4; }
        
        .print-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .print-table th { background: #f5f5f5 !important; padding: 10px 12px; text-align: left; border-bottom: 2px solid #000; font-size: 13px; }
        .print-table td { padding: 12px; border-bottom: 1px solid #eee; font-size: 13px; }
        
        .print-total-section { display: flex; justify-content: flex-end; }
        .print-total-box { width: 280px; border: 2px solid #000; padding: 12px; text-align: right; }
        .print-total-box p { margin: 0; font-size: 12px; font-weight: bold; }
        .print-total-box .grand-total { font-size: 22px; color: #000; margin-top: 5px; font-weight: 800; }
        
        .print-footer { margin-top: 40px; text-align: center; font-size: 11px; color: #777; border-top: 1px solid #eee; padding-top: 15px; }
    }
</style>

<!-- ==============================================
     1. LAYOUT WEB (Skrin Sahaja)
=============================================== -->
<div class="receipt-full-page">
    <div class="receipt-grid">
        <!-- Kiri: Butiran Pembayaran & Kereta -->
        <div class="panel-box">
            <h2 style="color: #e50914; margin-top: 0; border-bottom: 2px solid #e50914; padding-bottom: 10px;">
                Detailed Payment Receipt
            </h2>

            <!-- Baris 1: Receipt Number & Booking Ref -->
            <div class="detail-grid-row">
                <div>
                    <label class="detail-label">Receipt Number</label>
                    <div class="detail-value">#REC-<?= str_pad((string)$payment->id, 5, '0', STR_PAD_LEFT) ?></div>
                </div>
                <div>
                    <label class="detail-label">Booking Reference</label>
                    <div class="detail-value">#BKG-<?= h($payment->booking_id) ?></div>
                </div>
            </div>

            <!-- Baris 2: Rented Vehicle & Plate Number / Specs -->
            <div class="detail-grid-row">
                <div>
                    <label class="detail-label">Rented Vehicle</label>
                    <div class="detail-value">
                        <?= h($carModel) ?>
                        <span class="plate-badge"><?= h($plateNumber) ?></span>
                    </div>
                </div>
                <div>
                    <label class="detail-label">Vehicle Specs</label>
                    <div class="detail-value"><?= h($transmission) ?> &bull; <?= h($seats) ?> Seats</div>
                </div>
            </div>

            <!-- Baris 3: Pickup & Drop-off Location -->
            <div class="detail-grid-row">
                <div>
                    <label class="detail-label">Pickup Location</label>
                    <div class="detail-value"><?= h($pickupLocation) ?></div>
                </div>
                <div>
                    <label class="detail-label">Drop-off Location</label>
                    <div class="detail-value"><?= h($dropoffLocation) ?></div>
                </div>
            </div>

            <!-- Baris 4: Payment Method, Date & Status -->
            <div class="detail-grid-row">
                <div>
                    <label class="detail-label">Payment Method</label>
                    <div class="detail-value"><?= h($payment->payment_method ?? 'ToyyibPay (FPX)') ?></div>
                </div>
                <div>
                    <label class="detail-label">Payment Status</label>
                    <div class="detail-value" style="color: #28a745; font-weight: bold;">
                        <?= h(strtoupper($payment->payment_status)) ?>
                    </div>
                </div>
            </div>
            
            <div style="margin-top: 10px;">
                <label class="detail-label">Payment Date & Time</label>
                <div class="detail-value"><?= h($payment->payment_time ?? $payment->created) ?></div>
            </div>
        </div>

        <!-- Kanan: Ringkasan & Butang -->
        <div class="panel-box" style="height: fit-content;">
            <h3 style="margin-top: 0; color: #e50914; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                Payment Summary
            </h3>

            <div style="text-align: center; margin: 15px 0;">
                <span class="status-badge-paid">✓ PAYMENT SUCCESSFUL</span>
            </div>

            <div class="total-amount-box">
                <span style="font-size: 0.85em; text-transform: uppercase; letter-spacing: 1px; color: #28a745; font-weight: bold;">
                    Total Deposit Paid
                </span>
                <div class="total-amount-text">
                    RM <?= number_format((float)$payment->total_payment, 2) ?>
                </div>
            </div>

            <div style="margin-top: 25px;">
                <?= $this->Html->link(
                    __('Back to Dashboard'),
                    ['controller' => 'Customers', 'action' => 'dashboard'],
                    ['class' => 'btn-action-primary']
                ) ?>
                <button onclick="window.print()" class="btn-action-secondary">
                    Print Receipt
                </button>
            </div>

            <div class="summary-note">
                <p style="margin: 0;">* This is an official computer-generated receipt. Please retain this receipt or present it upon vehicle collection.</p>
            </div>
        </div>
    </div>
</div>

<!-- ==============================================
     2. LAYOUT PRINT (Inbois A4 Cetakan)
=============================================== -->
<div class="print-only-receipt">
    
    <div class="print-header">
        <div class="print-logo">
            <h1>SF CAR RENTAL</h1>
            <p>SF Car Rental HQ, Shah Alam, Selangor</p>
            <p>Tel: +6017-244 9251 | Web: sfcarrental.com</p>
        </div>
        <div class="print-title">
            <h2>OFFICIAL RECEIPT</h2>
            <p>Receipt No: #REC-<?= str_pad((string)$payment->id, 5, '0', STR_PAD_LEFT) ?></p>
            <p style="font-weight: normal; font-size: 12px; margin-top: 3px;">
                Date: <?= date('d M Y, h:i A', strtotime((string)($payment->payment_time ?? $payment->created))) ?>
            </p>
        </div>
    </div>

    <div class="print-info-row">
        <div class="print-info-box">
            <h4>Booking Information</h4>
            <p><strong>Booking Ref:</strong> #BKG-<?= h($payment->booking_id) ?></p>
            <p><strong>Payment Status:</strong> <span style="text-transform: uppercase; color: #28a745; font-weight: bold;"><?= h($payment->payment_status) ?></span></p>
            <p><strong>Payment Method:</strong> <?= h($payment->payment_method ?? 'ToyyibPay (FPX)') ?></p>
        </div>
        
        <div class="print-info-box">
            <h4>Location Details</h4>
            <p><strong>Pickup:</strong> <?= h($pickupLocation) ?></p>
            <p><strong>Drop-off:</strong> <?= h($dropoffLocation) ?></p>
        </div>
    </div>

    <table class="print-table">
        <thead>
            <tr>
                <th style="width: 5%;">No.</th>
                <th style="width: 50%;">Description / Rented Vehicle</th>
                <th style="width: 20%; text-align: center;">Payment Type</th>
                <th style="width: 25%; text-align: right;">Amount (RM)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1.</td>
                <td>
                    <strong><?= h($carModel) ?></strong> [Plate: <strong><?= h($plateNumber) ?></strong>]<br>
                    <span style="font-size: 11px; color: #555;">
                        Specs: <?= h($transmission) ?> &bull; <?= h($seats) ?> Seats | Booking Ref: #BKG-<?= h($payment->booking_id) ?>
                    </span>
                </td>
                <td style="text-align: center;">Deposit Payment</td>
                <td style="text-align: right;"><?= number_format((float)$payment->total_payment, 2) ?></td>
            </tr>
        </tbody>
    </table>

    <div class="print-total-section">
        <div class="print-total-box">
            <p>TOTAL PAID (RM)</p>
            <div class="grand-total"><?= number_format((float)$payment->total_payment, 2) ?></div>
        </div>
    </div>

    <div class="print-footer">
        <p>This is an official computer-generated receipt. No signature is required.</p>
        <p>Thank you for choosing SF Car Rental!</p>
    </div>
</div>