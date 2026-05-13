<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, sans-serif; font-size:9px; color:#1a1a18; padding:30px; }
        .header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:25px; padding-bottom:15px; border-bottom:2px solid #1a1a18; }
        .logo { font-size:22px; font-weight:800; letter-spacing:0.1em; }
        .report-title { text-align:right; }
        .report-title h2 { font-size:13px; font-weight:700; }
        .report-title p { font-size:9px; color:#6b6b65; margin-top:3px; }
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        thead tr { background:#1a1a18; color:#fff; }
        thead th { padding:7px 6px; font-size:8px; letter-spacing:0.1em; text-transform:uppercase; text-align:left; }
        tbody tr:nth-child(even) { background:#f5f0eb; }
        tbody td { padding:6px; font-size:8px; border-bottom:0.5px solid #e0dbd3; }
        .summary { margin-top:20px; display:flex; justify-content:flex-end; }
        .summary table { width:300px; }
        .summary td { padding:5px 8px; }
        .summary .total td { font-weight:800; font-size:11px; border-top:2px solid #1a1a18; }
        .badge { padding:2px 6px; border-radius:2px; font-size:7px; font-weight:700; letter-spacing:0.1em; }
        .badge-confirmed { background:#d1fae5; color:#065f46; }
        .badge-pending { background:#fef3c7; color:#92400e; }
        .badge-completed { background:#e5e7eb; color:#374151; }
        .badge-cancelled { background:#fee2e2; color:#991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <div class="logo">PLURAL</div>
            <div style="font-size:8px; color:#6b6b65; margin-top:3px; letter-spacing:0.15em;">PT. BOUT TRAINING STUDIO</div>
        </div>
        <div class="report-title">
            <h2>BOOKING REPORT</h2>
            <p>Period: {{ $period }}</p>
            <p>Generated: {{ now()->format('d M Y, H:i') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Space</th>
                <th>Date</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Total (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $i => $booking)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $booking->invoice_number ?? '-' }}</td>
                <td>
                    <strong>{{ $booking->name }}</strong><br>
                    <span style="color:#6b6b65;">{{ $booking->whatsapp }}</span>
                </td>
                <td>{{ $booking->space?->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                <td>{{ $booking->duration }}</td>
                <td>
                    <span class="badge badge-{{ $booking->status }}">
                        {{ strtoupper($booking->status) }}
                    </span>
                </td>
                <td>{{ $booking->total_price ? 'Rp ' . number_format($booking->total_price, 0, ',', '.') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td>Total Bookings</td>
                <td><strong>{{ $bookings->count() }}</strong></td>
            </tr>
            <tr>
                <td>Confirmed / Completed</td>
                <td><strong>{{ $bookings->whereIn('status', ['confirmed', 'completed'])->count() }}</strong></td>
            </tr>
            <tr>
                <td>Cancelled</td>
                <td><strong>{{ $bookings->where('status', 'cancelled')->count() }}</strong></td>
            </tr>
            <tr class="total">
                <td>Total Revenue (IDR)</td>
                <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>