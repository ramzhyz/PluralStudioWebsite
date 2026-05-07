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

        /* INFO TABLE */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .info-table td {
            padding: 7px 10px;
            border: 1px solid #c8c3bc;
            vertical-align: top;
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

        /* WAIVER TEXT */
        .waiver-intro {
            font-size: 10px;
            color: #4a4a45;
            margin-bottom: 10px;
            line-height: 1.7;
        }
        .waiver-list {
            padding-left: 16px;
            margin: 0;
        }
        .waiver-list li {
            font-size: 9.5px;
            color: #4a4a45;
            margin-bottom: 5px;
            line-height: 1.65;
        }
        .waiver-agree {
            font-size: 10px;
            margin-top: 12px;
            font-style: italic;
            color: #4a4a45;
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
    <div class="doc-title">PLURAL STUDIO — Rental Registration Form &amp; Waiver</div>

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
            <td class="value">{{ number_format((int) $deposit_amount, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Payment Method (Deposit)</td>
            <td class="value">{{ $deposit_method }}</td>
        </tr>
    </table>

    {{-- WAIVER --}}
    <div class="section-label">Studio Rules &amp; Waiver</div>
    <p class="waiver-intro">
        Rental periods are pre-arranged at the time of booking. The Client's rental time begins promptly at the
        designated starting time and ends promptly at the designated ending time, including setup and breakdown time.
        For your convenience while using the studio, please consider the following:
    </p>
    <ol class="waiver-list">
        <li>Please give your cash deposit to the reception desk before starting to use the studio.</li>
        <li>Please be aware of our strict overtime policy. Each booking should be mindful of the start and end time of your studio rental booking. Failure to vacate the studio by the designated ending time will automatically be considered overtime, and the Client will be charged an hourly rental fee of Rp1,000,000/hour.</li>
        <li>Please notify the reception before using a paper backdrop so we can assist you.</li>
        <li>The studio must be cleaned and vacated precisely by the end of the rental period. Failure to vacate the studio on time will result in additional charges as per the overtime policy.</li>
        <li>If you want to extend the studio rental time for more than 1 hour, please make a payment in advance by cash. Overtime is charged on an hourly basis and is non-transferable.</li>
        <li>The Client shall be solely responsible for any damage to the Company's property or equipment that occurs during the time the Client or their party occupies the Premises.</li>
        <li>Please return all studio properties to their original positions as when you arrived. All equipment, additional equipment, and belongings brought to the Premises must be removed by the Client after the shoot.</li>
        <li>Only models are allowed to wear shoes on the cyclorama/stage/paper backdrop, and their shoes must be clean. The studio provides tape to cover the bottom of the models' shoes to ensure the stage remains clean for the duration of the shoot.</li>
        <li>The Client agrees to pay for damage to the Premises, including spills, excessive wear, marks, or stains on furniture, fixtures or painted surfaces.</li>
        <li>Failure to adhere to any of the studio rules may result in a partial refund of your deposit.</li>
        <li>The studio is rented as-is. Any claims for disruptions must be reported immediately during the session and will be assessed based on the severity of impact to the actual shoot. Minor inconveniences that do not materially affect the booking are not grounds for discount.</li>
    </ol>
    <p class="waiver-agree">By signing this form, you agree to the rules mentioned above. Thank you for your cooperation.</p>

    {{-- SIGNATURES --}}
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