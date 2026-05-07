<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-Out — {{ $booking->name }}</title>
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
        .header .logo { font-size: 1.2rem; font-weight: 800; letter-spacing: 0.2em; }
        .header .title { font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase; opacity: 0.6; }

        .container { max-width: 800px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }

        .section-title {
            font-size: 0.6rem; font-weight: 700; letter-spacing: 0.2em;
            text-transform: uppercase; color: #6b6b65;
            margin: 2rem 0 1rem; padding-bottom: 0.5rem;
            border-bottom: 1px solid #e0dbd3;
        }

        .booking-banner {
            background: #1a1a18; color: #fff;
            padding: 1.25rem 1.5rem; margin-bottom: 2rem;
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;
        }
        .booking-banner .bitem label {
            font-size: 0.55rem; letter-spacing: 0.15em;
            text-transform: uppercase; opacity: 0.5; display: block; margin-bottom: 0.25rem;
        }
        .booking-banner .bitem .bval { font-size: 0.82rem; font-weight: 500; }

        .form-group { margin-bottom: 1.25rem; }
        .form-group label {
            display: block; font-size: 0.6rem; letter-spacing: 0.15em;
            text-transform: uppercase; color: #6b6b65; margin-bottom: 0.5rem;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%; padding: 0.75rem 1rem;
            border: 1px solid #e0dbd3; background: #fff;
            font-size: 0.82rem; font-family: inherit; color: #1a1a18;
            outline: none; transition: border 0.2s;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus { border-color: #1a1a18; }

        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }

        /* Charges table */
        .charges-table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
        .charges-table th {
            background: #1a1a18; color: #fff;
            font-size: 0.58rem; letter-spacing: 0.15em;
            text-transform: uppercase; padding: 0.6rem 0.85rem;
            text-align: left; font-weight: 700;
        }
        .charges-table td {
            padding: 0.65rem 0.85rem;
            border-bottom: 1px solid #e0dbd3;
            background: #fff; font-size: 0.8rem;
            vertical-align: middle;
        }
        .charges-table td select,
        .charges-table td input {
            width: 100%; padding: 0.4rem 0.6rem;
            border: 1px solid #e0dbd3; background: #faf8f5;
            font-size: 0.78rem; font-family: inherit; outline: none;
        }
        .charges-table td select:focus,
        .charges-table td input:focus { border-color: #1a1a18; }

        /* Inspection table */
        .inspection-table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
        .inspection-table th {
            background: #1a1a18; color: #fff;
            font-size: 0.58rem; letter-spacing: 0.15em;
            text-transform: uppercase; padding: 0.6rem 0.85rem;
            text-align: left; font-weight: 700;
        }
        .inspection-table td {
            padding: 0.65rem 0.85rem;
            border-bottom: 1px solid #e0dbd3;
            background: #fff; font-size: 0.82rem;
            vertical-align: middle;
        }
        .inspection-table td select {
            padding: 0.4rem 0.6rem;
            border: 1px solid #e0dbd3; background: #faf8f5;
            font-size: 0.78rem; font-family: inherit; outline: none;
            width: 100%;
        }

        /* Signature Pad */
        .signature-wrap { border: 1px solid #e0dbd3; background: #fff; position: relative; }
        .signature-wrap canvas { display: block; width: 100%; height: 180px; touch-action: none; cursor: crosshair; }
        .signature-actions {
            display: flex; justify-content: flex-end;
            padding: 0.5rem; border-top: 1px solid #e0dbd3; gap: 0.5rem;
        }
        .btn-clear {
            padding: 0.35rem 0.85rem; border: 1px solid #e0dbd3;
            background: transparent; font-size: 0.6rem; letter-spacing: 0.1em;
            text-transform: uppercase; cursor: pointer; color: #6b6b65;
        }
        .btn-clear:hover { background: #f5f0eb; }

        .btn-submit {
            width: 100%; padding: 1rem; background: #1a1a18; color: #fff;
            border: none; font-size: 0.7rem; letter-spacing: 0.2em;
            text-transform: uppercase; cursor: pointer; font-family: inherit;
            transition: opacity 0.2s; margin-top: 2rem;
        }
        .btn-submit:hover { opacity: 0.85; }

        .info-box {
            background: #fff; border: 1px solid #e0dbd3; padding: 0.85rem 1rem;
        }
        .info-box label {
            font-size: 0.58rem; letter-spacing: 0.15em; text-transform: uppercase;
            color: #6b6b65; display: block; margin-bottom: 0.3rem;
        }
        .info-box .value { font-size: 0.85rem; font-weight: 500; color: #1a1a18; }
    </style>
</head>
<body>

<div class="header">
    <div class="logo">PLURAL</div>
    <div class="title">Check-Out</div>
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

    <form method="POST" action="{{ route('checkout.store', $booking) }}" id="checkoutForm">
        @csrf

        {{-- Staff Info --}}
        <div class="section-title">Staff Information</div>
        <div class="form-group">
            <label>Staff Name *</label>
            <input type="text" name="staff_name" required placeholder="Staff on duty"
                value="{{ $booking->staff_name }}">
        </div>

        {{-- Additional Charges --}}
        <div class="section-title">Additional Charges</div>
        <table class="charges-table">
            <thead>
                <tr>
                    <th style="width:45%;">Item</th>
                    <th style="width:20%;">Yes / No</th>
                    <th style="width:35%;">Amount (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Overtime</td>
                    <td>
                        <select name="overtime" onchange="toggleAmount('overtime_amount', this.value)">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </td>
                    <td><input type="number" name="overtime_amount" id="overtime_amount" value="0" min="0" disabled></td>
                </tr>
                <tr>
                    <td>Cyclorama Damage / Repaint</td>
                    <td>
                        <select name="damage" onchange="toggleAmount('damage_amount', this.value)">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </td>
                    <td><input type="number" name="damage_amount" id="damage_amount" value="0" min="0" disabled></td>
                </tr>
                <tr>
                    <td>Cafe Orders</td>
                    <td>
                        <select name="cafe_orders" onchange="toggleAmount('cafe_amount', this.value)">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </td>
                    <td><input type="number" name="cafe_amount" id="cafe_amount" value="0" min="0" disabled></td>
                </tr>
                <tr>
                    <td>Other Charges</td>
                    <td>
                        <select name="other_charges" onchange="toggleAmount('other_amount', this.value)">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </td>
                    <td><input type="number" name="other_amount" id="other_amount" value="0" min="0" disabled></td>
                </tr>
            </tbody>
        </table>

        {{-- Studio Inspection --}}
        <div class="section-title">Studio Inspection</div>
        <table class="inspection-table">
            <thead>
                <tr>
                    <th style="width:60%;">Item</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cyclorama Wall</td>
                    <td>
                        <select name="cyclorama_status">
                            <option value="Ok">Ok</option>
                            <option value="Damage">Damage</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Floor</td>
                    <td>
                        <select name="floor_status">
                            <option value="Ok">Ok</option>
                            <option value="Damage">Damage</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Furniture</td>
                    <td>
                        <select name="furniture_status">
                            <option value="Ok">Ok</option>
                            <option value="Damage">Damage</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Lighting Equipment</td>
                    <td>
                        <select name="lighting_status">
                            <option value="Ok">Ok</option>
                            <option value="Damage">Damage</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Other Equipment</td>
                    <td>
                        <select name="equipment_status">
                            <option value="Ok">Ok</option>
                            <option value="Damage">Damage</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- Payment Summary --}}
        <div class="section-title">Payment Summary</div>
        <div class="form-row">
            <div class="form-group">
                <label>Total Charges (Rp)</label>
                <input type="number" name="total_charges" id="total_charges" value="0" min="0" readonly
                    style="background:#f5f0eb; font-weight:700;">
            </div>
            <div class="form-group">
                <label>Deposit Deducted (Rp)</label>
                <input type="number" name="deposit_deducted" id="deposit_deducted"
                    value="{{ $booking->deposit_amount ?? 1000000 }}" min="0" onchange="calcRemaining()">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Remaining Balance (Rp)</label>
                <input type="number" name="remaining_balance" id="remaining_balance" value="0" readonly
                    style="background:#f5f0eb; font-weight:700;">
            </div>
            <div class="form-group">
                <label>Payment Method (Final) *</label>
                <select name="payment_method_final" required>
                    <option value="">Select method</option>
                    <option value="Cash">Cash</option>
                    <option value="Card">Card</option>
                    <option value="Transfer">Transfer</option>
                    <option value="QRIS">QRIS</option>
                    <option value="Deposit Only">Deposit Only</option>
                </select>
            </div>
        </div>

        {{-- Staff Notes --}}
        <div class="section-title">Staff Notes & Kronologi</div>
        <div class="form-group">
            <label>General Notes</label>
            <textarea name="completion_notes" rows="3" placeholder="Catatan umum sesi ini..."></textarea>
        </div>
        <div class="form-group">
            <label>Damage / Incident Notes</label>
            <textarea name="damage_notes" rows="3" placeholder="Kronologi kerusakan atau insiden (jika ada)..."></textarea>
        </div>

        {{-- Signatures --}}
        <div class="section-title">Signatures</div>
        <div class="form-row">
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
            Complete Check-Out & Generate PDF
        </button>
    </form>
</div>

<script>
    // Signature Pads
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
        if (clientPad.isEmpty()) { alert('Client signature is required!'); return false; }
        if (staffPad.isEmpty())  { alert('Staff signature is required!');  return false; }
        document.getElementById('clientSignatureData').value = clientPad.toDataURL('image/png');
        document.getElementById('staffSignatureData').value  = staffPad.toDataURL('image/png');
        return true;
    }

    window.addEventListener('resize', () => {
        resizeCanvas(clientCanvas);
        resizeCanvas(staffCanvas);
    });

    // Toggle amount inputs
    function toggleAmount(fieldId, val) {
        const el = document.getElementById(fieldId);
        if (val === 'Yes') {
            el.disabled = false;
            el.focus();
        } else {
            el.disabled = false;
            el.value = 0;
            el.disabled = true;
        }
        calcTotal();
    }

    // Auto-calculate total
    function calcTotal() {
        const fields = ['overtime_amount', 'damage_amount', 'cafe_amount', 'other_amount'];
        let total = 0;
        fields.forEach(id => {
            const el = document.getElementById(id);
            if (!el.disabled) total += parseInt(el.value) || 0;
        });
        document.getElementById('total_charges').value = total;
        calcRemaining();
    }

    function calcRemaining() {
        const total    = parseInt(document.getElementById('total_charges').value) || 0;
        const deposit  = parseInt(document.getElementById('deposit_deducted').value) || 0;
        const remaining = total - deposit;
        document.getElementById('remaining_balance').value = remaining < 0 ? 0 : remaining;
    }

    // Listen to amount inputs
    ['overtime_amount','damage_amount','cafe_amount','other_amount'].forEach(id => {
        document.getElementById(id).addEventListener('input', calcTotal);
    });

    calcTotal();
</script>

</body>
</html>