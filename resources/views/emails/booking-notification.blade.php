<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { font-family: Arial, sans-serif; font-size: 14px; color: #374151; margin: 0; padding: 0; background: #f9fafb; }
.wrap { max-width: 560px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; }
.header { background: #1e3a2f; color: white; padding: 24px 32px; }
.body { padding: 28px 32px; }
table { width:100%; border-collapse:collapse; font-size:13px; margin-bottom:16px; }
td { padding:7px 0; border-bottom:1px solid #f3f4f6; }
td:last-child { text-align:right; font-weight:500; }
.total td { border-bottom:none; font-weight:700; font-size:15px; }
.btn { display:inline-block; background:#1a7849; color:white; padding:10px 22px; border-radius:50px; text-decoration:none; font-weight:600; font-size:13px; }
</style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <h2 style="margin:0;font-size:16px">New Booking Request — {{ $booking->reference }}</h2>
        <p style="margin:4px 0 0;opacity:.7;font-size:13px">{{ now()->format('D, d M Y H:i') }}</p>
    </div>
    <div class="body">
        <table>
            <tr><td style="color:#6b7280">Reference</td><td><strong>{{ $booking->reference }}</strong></td></tr>
            <tr><td style="color:#6b7280">Group</td><td>{{ $booking->group_name }} ({{ ucfirst($booking->group_type) }})</td></tr>
            <tr><td style="color:#6b7280">Contact</td><td>{{ $booking->contact_name }}</td></tr>
            <tr><td style="color:#6b7280">Email</td><td>{{ $booking->contact_email }}</td></tr>
            <tr><td style="color:#6b7280">Phone</td><td>{{ $booking->contact_phone }}</td></tr>
            <tr><td style="color:#6b7280">Arrival</td><td>{{ $booking->arrival_date->format('d M Y') }}</td></tr>
            <tr><td style="color:#6b7280">Departure</td><td>{{ $booking->departure_date->format('d M Y') }}</td></tr>
            <tr><td style="color:#6b7280">Guests</td><td>{{ $booking->pax_count }}</td></tr>
            <tr><td style="color:#6b7280">Accommodation</td><td>{{ ucfirst(str_replace('_',' ',$booking->accommodation_type)) }}</td></tr>
        </table>

        <table>
            @foreach($quote['facility_lines'] as $l)
            <tr><td>{{ $l['label'] }}</td><td>US${{ number_format($l['subtotal'],2) }}</td></tr>
            @endforeach
            @foreach($quote['activity_lines'] as $l)
            <tr><td>{{ $l['label'] }}</td><td>US${{ number_format($l['subtotal'],2) }}</td></tr>
            @endforeach
            <tr class="total"><td>Total quote</td><td style="color:#1a7849">US${{ number_format($quote['total'],2) }}</td></tr>
        </table>

        @if($booking->special_requirements)
        <p style="background:#fefce8;padding:12px;border-radius:8px;font-size:13px"><strong>Special requirements:</strong> {{ $booking->special_requirements }}</p>
        @endif

        <p style="text-align:center;margin-top:20px">
            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn">View & Confirm Booking →</a>
        </p>
    </div>
</div>
</body>
</html>
