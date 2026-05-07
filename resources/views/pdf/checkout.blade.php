<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1a1a18;
            padding: 40px 50px;
            line-height: 1.5;
        }

        /* HEADER */
        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 2px solid #1a1a18;
            padding-bottom: 16px;
        }
        .header-logo {
            display: table-cell;
            vertical-align: middle;
            width: 50%;
        }
        .logo-box {
            display: inline-block;
            border: 2.5px solid #1a1a18;
            padding: 6px 16px;
            font-size: 18px;
            font-weight: 900;
            letter-spacing: 0.25em;
        }
        .header-address {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            font-size: 9px;
            color: #6b6b65;
            line-height: 1.6;
        }

        /* TITLE */
        .doc-title {
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            margin-bottom: 24px;
        }

        /* SECTION LABEL */
        .section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #1a1a18;
            margin: 20px 0 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #1a1a18;
        }

        /* TABLES */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .info-table td, .info-table th {
            padding: 7px 10px;
            border: 1px solid #c8c3bc;
            vertical-align: middle;
        }
        .info-table th {
            background: #1a1a18;
            color: #fff;
            font-size: 9px;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-weight: 700;
            text-align: left;
        }
        .info-table td.label {
            width: 45%;
            color: #6b6b65;
            font-size: 10px;
        }
        .info-table td.value {
            font-weight: 700;
            font-size: 10.5px;
        }
        .info-table td.center {
            text-align: center;
        }
        .info-table td.total-label {
            font-weight: 700;
            font-size: 10.5px;
            background: #f5f0eb;
        }
        .info-table td.total-value {
            font-weight: 900;
            font-size: 11px;
            background: #f5f0eb;
        }

        .badge-ok {
            color: #166534;
            font-weight: 700;
        }
        .badge-damage {
            color: #991b1b;
            font-weight: 700;
        }
        .badge-yes {
            color: #92400e;
            font-weight: 700;
        }
        .badge-no {
            color: #6b6b65;
        }

        /* NOTES BOX */
        .notes-box {
            border: 1px solid #c8c3bc;
            padding: 10px 12px;
            font-size: 10px;
            color: #4a4a45;
            min-height: 60px;
            line-height: 1.7;
        }
        .notes-empty {
            color: #c8c3bc;
            font-style: italic;
        }

        /* SIGNATURE TABLE */
        .sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .sig-table td {
            border: 1px solid #c8c3bc;
            padding: 10px;
            vertical-align: top;
            width: 50%;
        }
        .sig-label {
            font-size: 9px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #6b6b65;
            margin-bottom: 4px;
        }
        .sig-name {
            font-weight: 700;
            font-size: 10.5px;
            margin-bottom: 8px;
        }
        .sig-image {
            height: 70px;
            display: block;
        }

        /* FOOTER */
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #c8c3bc;
            font-size: 8.5px;
            color: #9b9b95;
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-logo">
            <div class="logo-box">PLURAL</div>
        </div>
        <div class="header-address">
            Tibubeneng, Kec. Kuta Utara<br>
            Kabupaten Badung, Bali 80361
        </div>
    </div>

    {{-- TITLE --}}
    <div class="doc-title">PLURAL STUDIO — Booking Check-In / Checkout Control Sheet</div>

    {{-- CHECK-IN INFO --}}
    <div class="section-label">Check-In Information</div>
    <table class="info-table">
        <tr>
            <td class="label">Client Name</td>
            <td class="value">{{ $booking->name }}</td>
        </tr>
        <tr>
            <td class="label">Studio / Room</td>
            <td class="value">{{ $booking->space?->name }}</td>
        </tr>
        <tr>
            <td class="label">Booking Date</td>
            <td class="value">{{ $booking_date }}</td>
        </tr>
        <tr>
            <td class="label">Booking Time</td>
            <td class="value">{{ $booking_time }}</td>
        </tr>
        <tr>
            <td class="label">Staff On Duty</td>
            <td class="value">{{ $staff_name }}</td>
        </tr>
        <tr>
            <td class="label">Deposit Collected (Rp)</td>
            <td class="value">{{ number_format((int) $booking->deposit_amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Payment Method (Deposit)</td>
            <td class="value">{{ $booking->deposit_method }}</td>
        </tr>
    </table>

    {{-- ADDITIONAL CHARGES --}}
    <div class="section-label">Additional Charges</div>
    <table class="info-table">
        <tr>
            <th style="width:50%;">Additional Charges</th>
            <th style="width:25%; text-align:center;">Yes / No</th>
            <th style="width:25%; text-align:right;">Amount (Rp)</th>
        </tr>
        <tr>
            <td>Overtime</td>
            <td class="center">
                <span class="{{ $overtime === 'Yes' ? 'badge-yes' : 'badge-no' }}">{{ $overtime }}</span>
            </td>
            <td style="text-align:right;">
                @if($overtime === 'Yes') {{ number_format((int)$overtime_amount, 0, ',', '.') }} @endif
            </td>
        </tr>
        <tr>
            <td>Cyclorama Damage / Repaint</td>
            <td class="center">
                <span class="{{ $damage === 'Yes' ? 'badge-yes' : 'badge-no' }}">{{ $damage }}</span>
            </td>
            <td style="text-align:right;">
                @if($damage === 'Yes') {{ number_format((int)$damage_amount, 0, ',', '.') }} @endif
            </td>
        </tr>
        <tr>
            <td>Cafe Orders</td>
            <td class="center">
                <span class="{{ $cafe_orders === 'Yes' ? 'badge-yes' : 'badge-no' }}">{{ $cafe_orders }}</span>
            </td>
            <td style="text-align:right;">
                @if($cafe_orders === 'Yes') {{ number_format((int)$cafe_amount, 0, ',', '.') }} @endif
            </td>
        </tr>
        <tr>
            <td>Other Charges</td>
            <td class="center">
                <span class="{{ $other_charges === 'Yes' ? 'badge-yes' : 'badge-no' }}">{{ $other_charges }}</span>
            </td>
            <td style="text-align:right;">
                @if($other_charges === 'Yes') {{ number_format((int)$other_amount, 0, ',', '.') }} @endif
            </td>
        </tr>
    </table>

    {{-- STUDIO INSPECTION --}}
    <div class="section-label">Studio Inspection (Completed before checkout)</div>
    <table class="info-table">
        <tr>
            <th style="width:60%;">Studio Damage Inspections</th>
            <th>Status</th>
        </tr>
        <tr>
            <td>Cyclorama Wall</td>
            <td><span class="{{ $cyclorama_status === 'Ok' ? 'badge-ok' : 'badge-damage' }}">{{ $cyclorama_status }}</span></td>
        </tr>
        <tr>
            <td>Floor</td>
            <td><span class="{{ $floor_status === 'Ok' ? 'badge-ok' : 'badge-damage' }}">{{ $floor_status }}</span></td>
        </tr>
        <tr>
            <td>Furniture</td>
            <td><span class="{{ $furniture_status === 'Ok' ? 'badge-ok' : 'badge-damage' }}">{{ $furniture_status }}</span></td>
        </tr>
        <tr>
            <td>Lighting Equipment</td>
            <td><span class="{{ $lighting_status === 'Ok' ? 'badge-ok' : 'badge-damage' }}">{{ $lighting_status }}</span></td>
        </tr>
        <tr>
            <td>Other Equipment</td>
            <td><span class="{{ $equipment_status === 'Ok' ? 'badge-ok' : 'badge-damage' }}">{{ $equipment_status }}</span></td>
        </tr>
    </table>

    {{-- PAYMENT SUMMARY --}}
    <div class="section-label">Payment Summary</div>
    <table class="info-table">
        <tr>
            <td class="total-label">Total Charges (Rp)</td>
            <td class="total-value">{{ number_format((int)$total_charges, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Deposit Deducted (Rp)</td>
            <td class="value">{{ number_format((int)$deposit_deducted, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Remaining Balance (Rp)</td>
            <td class="value">{{ number_format((int)$remaining, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Payment Method (Final)</td>
            <td class="value">{{ $payment_method }}</td>
        </tr>
    </table>

    {{-- STAFF NOTES --}}
    @if(!empty($booking->completion_notes) || !empty($booking->damage_notes))
    <div class="section-label">Staff Notes &amp; Kronologi</div>
    @if(!empty($booking->completion_notes))
    <p style="font-size:9px; color:#6b6b65; margin-bottom:4px; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;">General Notes</p>
    <div class="notes-box" style="margin-bottom:10px;">{{ $booking->completion_notes }}</div>
    @endif
    @if(!empty($booking->damage_notes))
    <p style="font-size:9px; color:#6b6b65; margin-bottom:4px; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;">Damage / Incident Notes</p>
    <div class="notes-box">{{ $booking->damage_notes }}</div>
    @endif
    @endif

    {{-- CONFIRMATION & SIGNATURES --}}
    <div class="section-label">Confirmation &amp; Signatures</div>
    <table class="sig-table">
        <tr>
            <td>
                <div class="sig-label">Client Name</div>
                <div class="sig-name">{{ $booking->name }}</div>
                <div class="sig-label">Client Signature</div>
                <img src="{{ $client_signature }}" class="sig-image">
            </td>
            <td>
                <div class="sig-label">Reception Staff Name</div>
                <div class="sig-name">{{ $staff_name }}</div>
                <div class="sig-label">Reception Staff Signature</div>
                <img src="{{ $staff_signature }}" class="sig-image">
            </td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        Generated on {{ now()->format('d M Y, H:i') }} &nbsp;|&nbsp; PLURAL STUDIO &nbsp;|&nbsp; Tibubeneng, Kuta Utara, Bali
    </div>

</body>
</html>