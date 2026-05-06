<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1a1a18;
            background: #fff;
            padding: 40px;
        }

        /* ── HEADER ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 1px solid #e0dbd3;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #1a1a18;
        }
        .company-sub {
            font-size: 8px;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #6b6b65;
            margin-top: 4px;
        }
        .invoice-meta {
            text-align: right;
            font-size: 11px;
        }
        .invoice-meta .invoice-num {
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 0.05em;
        }
        .invoice-meta .invoice-date {
            color: #6b6b65;
            margin-top: 4px;
        }

        /* ── BILL TO ── */
        .bill-section {
            margin-bottom: 35px;
        }
        .bill-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #6b6b65;
            margin-bottom: 8px;
        }
        .bill-name {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 3px;
        }
        .bill-contact {
            color: #6b6b65;
            font-size: 10px;
            line-height: 1.6;
        }

        /* ── TABLE ── */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead tr {
            border-top: 1.5px solid #1a1a18;
            border-bottom: 1.5px solid #1a1a18;
        }
        thead th {
            padding: 8px 6px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #1a1a18;
        }
        thead th:first-child { text-align: left; }
        thead th:not(:first-child) { text-align: right; }

        tbody tr {
            border-bottom: 0.5px solid #e0dbd3;
        }
        tbody td {
            padding: 10px 6px;
            vertical-align: top;
        }
        tbody td:first-child { text-align: left; }
        tbody td:not(:first-child) { text-align: right; }

        .item-title {
            font-weight: 700;
            font-size: 11px;
            margin-bottom: 4px;
        }
        .item-detail {
            font-size: 9.5px;
            color: #6b6b65;
            line-height: 1.7;
        }

        /* ── TOTALS ── */
        .totals {
            width: 100%;
            margin-bottom: 30px;
        }
        .totals tr td {
            padding: 4px 6px;
            font-size: 10px;
        }
        .totals tr td:first-child { color: #6b6b65; text-align: right; width: 75%; }
        .totals tr td:last-child { text-align: right; font-weight: 600; }
        .totals .grand-total td {
            border-top: 1.5px solid #1a1a18;
            padding-top: 8px;
            font-size: 13px;
            font-weight: 800;
        }
        .totals .grand-total td:first-child { color: #1a1a18; }

        /* ── FOOTER SECTION ── */
        .footer-grid {
            display: flex;
            gap: 40px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 0.5px solid #e0dbd3;
        }
        .terms { flex: 1; }
        .bank-info { flex: 1; text-align: right; }

        .section-label {
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .terms ul {
            padding-left: 14px;
            color: #6b6b65;
            font-size: 9px;
            line-height: 1.75;
        }
        .bank-table td {
            font-size: 9.5px;
            padding: 2px 0;
            color: #6b6b65;
        }
        .bank-table td:first-child {
            padding-right: 10px;
            color: #1a1a18;
            font-weight: 600;
        }

        .payment-note {
            font-size: 8.5px;
            color: #6b6b65;
            margin-top: 15px;
            font-style: italic;
        }
        .payment-note strong {
            color: #1a1a18;
        }

        /* ── POLICIES ── */
        .policies {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 0.5px solid #e0dbd3;
        }
        .policies ul {
            padding-left: 14px;
            color: #6b6b65;
            font-size: 9px;
            line-height: 1.75;
            margin-top: 8px;
        }
        .policies ul li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div>
            <div class="logo">PLURAL</div>
            <div class="company-sub">PT. BOUT TRAINING STUDIO</div>
        </div>
        <div class="invoice-meta">
            <div class="invoice-num">INVOICE#{{ $invoice_number }}</div>
            <div class="invoice-date">{{ $invoice_date }}</div>
        </div>
    </div>

    {{-- BILL TO --}}
    <div class="bill-section">
        <div class="bill-label">Invoice<br>Bill to :</div>
        <div class="bill-name">{{ $customer_name }}</div>
        <div class="bill-contact">
            {{ $customer_email }}<br>
            +{{ $customer_whatsapp }}
        </div>
    </div>

    {{-- ITEMS TABLE --}}
    <table>
        <thead>
            <tr>
                <th style="width:50%;">Description</th>
                <th style="width:15%;">Quantity</th>
                <th style="width:17%;">Rate</th>
                <th style="width:18%;">Amount</th>
            </tr>
        </thead>
        <tbody>
            {{-- Studio Rent --}}
            <tr>
                <td>
                    <div class="item-title">Studio Rent</div>
                    <div class="item-detail">
                        Day &nbsp;&nbsp;&nbsp;&nbsp;: {{ $booking_day }}<br>
                        Date &nbsp;&nbsp;&nbsp;: {{ $booking_date }}<br>
                        Time &nbsp;&nbsp;&nbsp;: {{ $booking_time }}<br>
                        Location : {{ $space_name }} Studio
                    </div>
                </td>
                <td>{{ $studio_qty }}</td>
                <td>Rp. {{ number_format($studio_rate, 0, ',', '.') }},-</td>
                <td>Rp. {{ number_format($studio_amount, 0, ',', '.') }},-</td>
            </tr>

            {{-- Additional Charges --}}
            @foreach($additional_charges as $charge)
            <tr>
                <td>
                    <div class="item-title">Additional Charge</div>
                    <div class="item-detail">{{ $charge['description'] }}</div>
                </td>
                <td>{{ $charge['qty'] }}</td>
                <td>Rp. {{ number_format($charge['rate'], 0, ',', '.') }},-</td>
                <td>Rp. {{ number_format($charge['amount'], 0, ',', '.') }},-</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTALS --}}
    <table class="totals">
        <tr>
            <td>Total</td>
            <td>Rp. {{ number_format($subtotal, 0, ',', '.') }},-</td>
        </tr>
        <tr class="grand-total">
            <td>GRAND TOTAL</td>
            <td>Rp. {{ number_format($grand_total, 0, ',', '.') }},-</td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <div class="footer-grid">
        <div class="terms">
            <div class="section-label">Terms and Conditions :</div>
            <ul>
                <li>The total outstanding balance must be transferred by 5 PM today, and all payments is transfer to the following bank account :</li>
            </ul>

            <table class="bank-table" style="margin-top:10px; margin-left:14px;">
                <tr><td>Bank Name</td><td>: Permata</td></tr>
                <tr><td>Account Name</td><td>: PT. BOUT TRAINING STUDIO</td></tr>
                <tr><td>Account Number</td><td>: 4122047852</td></tr>
                <tr><td>Swift Code</td><td>: BBBAIDJA</td></tr>
            </table>

            <ul style="margin-top:10px;">
                <li>Security Deposit (Cash Only in Indonesian Rupiah).</li>
                <li>A cash deposit of Rp. 1.000.000 is required for each booking. Please bring this to the studio in person at the time of your booking—no bookings will be processed without it. The deposit covers potential overtime or damages and will be fully refunded after a post-shoot inspection, provided everything is in order.</li>
            </ul>
        </div>

        <div class="bank-info">
            <div class="payment-note">
                *** Please submit the screenshot of payment via email to :<br>
                <strong>pluralspacebali@gmail.com</strong> or via WhatsApp at <strong>+62853 3354 6361</strong>
            </div>
        </div>
    </div>

    {{-- BOOKING POLICIES --}}
    <div class="policies">
        <div class="section-label">Booking Policies and Fees :</div>
        <ul>
            <li>Studio Location Change: Once a booking is confirmed for a specific studio, switching to the other studio is not permitted. If an exception is made, a location change fee of Rp. 1.000.000 applies and is subject to availability.</li>
            <li>Reschedule Request: Rescheduling of confirmed bookings is not permitted. If an exception is made, an administrative fee of Rp. 1.000.000 applies and is subject to availability.</li>
            <li>Overtime: A 5-minute grace period is allowed for packing of belongings only after all bookings. Exceeding the scheduled time beyond this will result in an automatic overtime charge of Rp. 1.000.000.</li>
        </ul>
    </div>

</body>
</html>