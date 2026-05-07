<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-In — {{ $booking->name }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/4.1.7/signature_pad.umd.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, sans-serif;
            background: #faf8f5;
            color: #1a1a18;
            min-height: 100vh;
        }

        .header {
            background: #1a1a18;
            color: #fff;
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header .logo {
            font-size: 1.2rem;
            font-weight: 800;
            letter-spacing: 0.2em;
        }
        .header .title {
            font-size: 0.65rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            opacity: 0.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1.5rem 4rem;
        }

        .section-title {
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #6b6b65;
            margin: 2rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e0dbd3;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .info-box {
            background: #fff;
            border: 1px solid #e0dbd3;
            padding: 0.85rem 1rem;
        }
        .info-box label {
            font-size: 0.58rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #6b6b65;
            display: block;
            margin-bottom: 0.3rem;
        }
        .info-box .value {
            font-size: 0.85rem;
            font-weight: 500;
            color: #1a1a18;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-group label {
            display: block;
            font-size: 0.6rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #6b6b65;
            margin-bottom: 0.5rem;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e0dbd3;
            background: #fff;
            font-size: 0.82rem;
            font-family: inherit;
            color: #1a1a18;
            outline: none;
            transition: border 0.2s;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #1a1a18;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* Signature Pad */
        .signature-wrap {
            border: 1px solid #e0dbd3;
            background: #fff;
            position: relative;
        }
        .signature-wrap canvas {
            display: block;
            width: 100%;
            height: 180px;
            touch-action: none;
            cursor: crosshair;
        }
        .signature-actions {
            display: flex;
            justify-content: flex-end;
            padding: 0.5rem;
            border-top: 1px solid #e0dbd3;
            gap: 0.5rem;
        }
        .btn-clear {
            padding: 0.35rem 0.85rem;
            border: 1px solid #e0dbd3;
            background: transparent;
            font-size: 0.6rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            color: #6b6b65;
        }
        .btn-clear:hover { background: #f5f0eb; }

        /* Waiver text */
        .waiver-text {
            background: #fff;
            border: 1px solid #e0dbd3;
            padding: 1.5rem;
            font-size: 0.72rem;
            line-height: 1.85;
            color: #6b6b65;
            max-height: 300px;
            overflow-y: auto;
            margin-bottom: 1.5rem;
        }
        .waiver-text ol {
            padding-left: 1.2rem;
            margin-top: 0.75rem;
        }
        .waiver-text ol li {
            margin-bottom: 0.5rem;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: #1a1a18;
            color: #fff;
            border: none;
            font-size: 0.7rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            cursor: pointer;
            font-family: inherit;
            transition: opacity 0.2s;
            margin-top: 2rem;
        }
        .btn-submit:hover { opacity: 0.85; }

        .booking-banner {
            background: #1a1a18;
            color: #fff;
            padding: 1.25rem 1.5rem;
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }
        .booking-banner .bitem label {
            font-size: 0.55rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            opacity: 0.5;
            display: block;
            margin-bottom: 0.25rem;
        }
        .booking-banner .bitem .bval {
            font-size: 0.82rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="logo">PLURAL</div>
    <div class="title">Check-In Registration</div>
</div>

<div class="container">

    {{-- Booking Banner --}}
    <div class="booking-banner">
        <div class="bitem">
            <label>Client</label>
            <div class="bval">{{ $booking->name }}</div>
        </div>
        <div class="bitem">
            <label>Space</label>
            <div class="bval">{{ $booking->space?->name }}</div>
        </div>
        <div class="bitem">
            <label>Date</label>
            <div class="bval">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
        </div>
        <div class="bitem">
            <label>Time</label>
            <div class="bval">
                @php
                    $start = \Carbon\Carbon::parse($booking->booking_date);
                    $hours = (int) filter_var($booking->duration, FILTER_SANITIZE_NUMBER_INT);
                    $end   = $start->copy()->addHours($hours);
                @endphp
                {{ $start->format('H:i') }} - {{ $end->format('H:i') }}
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('checkin.store', $booking) }}" id="checkinForm">
        @csrf

        {{-- Staff Info --}}
        <div class="section-title">Staff Information</div>
        <div class="form-row">
            <div class="form-group">
                <label>Staff Name *</label>
                <input type="text" name="staff_name" required placeholder="Staff on duty">
            </div>
            <div class="form-group">
                <label>Deposit Amount (IDR)</label>
                <input type="text" name="deposit_amount" value="1000000" placeholder="1000000">
            </div>
        </div>
        <div class="form-group">
            <label>Deposit Payment Method *</label>
            <select name="deposit_method" required>
                <option value="">Select method</option>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Transfer">Transfer</option>
                <option value="QRIS">QRIS</option>
            </select>
        </div>

        {{-- Waiver --}}
        <div class="section-title">Rental Registration Form & Waiver</div>
        <div class="waiver-text">
            <strong>PLURAL STUDIO Rental Registration Form</strong><br><br>
            Rental periods are pre-arranged at the time of booking. The Client's rental time begins promptly at the designated starting time and ends promptly at the designated ending time, including setup and breakdown time. For your convenience while using the studio, please consider the following:
            <ol>
                <li>Please give your cash deposit to the reception desk before starting to use the studio.</li>
                <li>Please be aware of our strict overtime policy. Each booking should be mindful of the start and end time of your studio rental booking. Failure to vacate the studio by the designated ending time will automatically be considered overtime, and the Client will be charged an hourly rental fee of Rp1,000,000/hour.</li>
                <li>Please notify the reception before using a paper backdrop so we can assist you.</li>
                <li>The studio must be cleaned and vacated precisely by the end of the rental period. Failure to vacate the studio on time will result in additional charges as per the overtime policy.</li>
                <li>If you want to extend the studio rental time for more than 1 hour, please make a payment in advance by cash. Overtime is charged on an hourly basis and is non-transferable.</li>
                <li>The Client shall be solely responsible for any damage to the Company's property or equipment that occurs during the time the Client or their party occupies the Premises.</li>
                <li>Please return all studio properties to their original positions as when you arrived. All equipment, additional equipment, and belongings brought to the Premises must be removed by the Client after the shoot.</li>
                <li>Only models are allowed to wear shoes on the cyclorama/stage/paper backdrop, and their shoes must be clean. The studio provides tape to cover the bottom of the models shoes to ensure the stage remains clean for the duration of the shoot.</li>
                <li>The Client agrees to pay for damage to the Premises, including spills, excessive wear, marks, or stains on furniture, fixtures or painted surfaces.</li>
                <li>Failure to adhere to any of the studio rules may result in a partial refund of your deposit.</li>
                <li>The studio is rented as-is. Any claims for disruptions must be reported immediately during the session and will be assessed based on the severity of impact to the actual shoot. Minor inconveniences that do not materially affect the booking are not grounds for discount.</li>
            </ol>
        </div>

        {{-- Signatures --}}
        <div class="section-title">Signatures</div>
        <div class="form-row">
            {{-- Client Signature --}}
            <div class="form-group">
                <label>Client Signature *</label>
                <div class="signature-wrap">
                    <canvas id="clientCanvas"></canvas>
                    <div class="signature-actions">
                        <button type="button" class="btn-clear" onclick="clearSignature('client')">Clear</button>
                    </div>
                </div>
                <input type="hidden" name="client_signature" id="clientSignatureData">
            </div>

            {{-- Staff Signature --}}
            <div class="form-group">
                <label>Staff Signature *</label>
                <div class="signature-wrap">
                    <canvas id="staffCanvas"></canvas>
                    <div class="signature-actions">
                        <button type="button" class="btn-clear" onclick="clearSignature('staff')">Clear</button>
                    </div>
                </div>
                <input type="hidden" name="staff_signature" id="staffSignatureData">
            </div>
        </div>

        <button type="submit" class="btn-submit" onclick="return saveSignatures()">
            Complete Check-In & Generate PDF
        </button>
    </form>
</div>

<script>
    // Init signature pads
    const clientCanvas = document.getElementById('clientCanvas');
    const staffCanvas  = document.getElementById('staffCanvas');

    function resizeCanvas(canvas) {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width  = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext('2d').scale(ratio, ratio);
    }

    resizeCanvas(clientCanvas);
    resizeCanvas(staffCanvas);

    const clientPad = new SignaturePad(clientCanvas, { backgroundColor: 'rgb(255,255,255)' });
    const staffPad  = new SignaturePad(staffCanvas,  { backgroundColor: 'rgb(255,255,255)' });

    function clearSignature(who) {
        if (who === 'client') clientPad.clear();
        if (who === 'staff')  staffPad.clear();
    }

    function saveSignatures() {
        if (clientPad.isEmpty()) {
            alert('Client signature is required!');
            return false;
        }
        if (staffPad.isEmpty()) {
            alert('Staff signature is required!');
            return false;
        }
        document.getElementById('clientSignatureData').value = clientPad.toDataURL('image/png');
        document.getElementById('staffSignatureData').value  = staffPad.toDataURL('image/png');
        return true;
    }

    window.addEventListener('resize', () => {
        resizeCanvas(clientCanvas);
        resizeCanvas(staffCanvas);
    });
</script>

</body>
</html>