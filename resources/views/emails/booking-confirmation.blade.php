<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { font-family: Arial, sans-serif; font-size: 14px; color: #374151; margin: 0; padding: 0; background: #f9fafb; }
.wrap { max-width: 560px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 6px rgba(0,0,0,.06); }
.header { background: #1a7849; padding: 24px 36px; text-align: center; }
.header img { height: 48px; width: auto; object-fit: contain; filter: brightness(0) invert(1); opacity: .95; }
.header h1 { margin: 12px 0 0; font-size: 18px; font-weight: 600; color: white; }
.header p { margin: 4px 0 0; opacity: .8; font-size: 13px; color: #dcf3e4; }
.body { padding: 32px 36px; }
.ref { text-align:center; background: #f0faf4; border: 1px solid #b5e5c5; border-radius: 10px; padding: 16px; margin-bottom: 24px; }
.ref .label { font-size: 12px; color: #6b7280; }
.ref .code { font-size: 28px; font-weight: 700; color: #1a7849; letter-spacing: .04em; }
table { width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 16px; }
td { padding: 7px 0; border-bottom: 1px solid #f3f4f6; }
td:last-child { text-align: right; font-weight: 500; }
.total-row td { border-bottom: none; font-weight: 700; font-size: 14px; padding-top: 10px; }
.footer { padding: 20px 36px; background: #f9fafb; font-size: 12px; color: #9ca3af; text-align: center; }
.footer img { height: 24px; width: auto; object-fit: contain; opacity: .4; margin-bottom: 6px; }
</style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <img src="{{ config('app.url') }}/images/logo.png" alt="Eve Mountain Campsite">
        <h1>Booking Request Received</h1>
        <p>Eve Mountain Campsite · Zimbabwe</p>
    </div>
    <div class="body">
        <p>Dear {{ $booking->contact_name }},</p>
        <p>Thank you for your booking request. We will confirm availability and payment details within 24 hours.</p>

        <div class="ref">
            <div class="label">Your booking reference</div>
            <div class="code">{{ $booking->reference }}</div>
        </div>

        <table>
            <tr><td style="color:#6b7280">Group</td><td>{{ $booking->group_name }}</td></tr>
            <tr><td style="color:#6b7280">Arrival</td><td>{{ $booking->arrival_date->format('D, d M Y') }}</td></tr>
            <tr><td style="color:#6b7280">Departure</td><td>{{ $booking->departure_date->format('D, d M Y') }}</td></tr>
            <tr><td style="color:#6b7280">Nights</td><td>{{ $booking->nights }}</td></tr>
            <tr><td style="color:#6b7280">Guests</td><td>{{ $booking->pax_count }}</td></tr>
            <tr><td style="color:#6b7280">Accommodation</td><td>{{ ucfirst(str_replace('_',' ',$booking->accommodation_type)) }}</td></tr>
        </table>

        <p style="font-weight:600;font-size:13px;margin-bottom:8px">Quote breakdown</p>
        <table>
            @foreach($quote['facility_lines'] as $line)
            <tr><td style="color:#4b5563">{{ $line['label'] }}</td><td>US${{ number_format($line['subtotal'],2) }}</td></tr>
            @endforeach
            @foreach($quote['activity_lines'] as $line)
            <tr><td style="color:#4b5563">{{ $line['label'] }}</td><td>US${{ number_format($line['subtotal'],2) }}</td></tr>
            @endforeach
            <tr class="total-row"><td>Total estimate</td><td style="color:#1a7849">US${{ number_format($quote['total'],2) }}</td></tr>
        </table>

        @if($booking->special_requirements)
        <p style="background:#fefce8;border:1px solid #fde68a;border-radius:8px;padding:12px;font-size:13px;color:#92400e">
            <strong>Special requirements noted:</strong> {{ $booking->special_requirements }}
        </p>
        @endif

        <p style="color:#6b7280;font-size:13px">We will contact you at <strong>{{ $booking->contact_email }}</strong> or <strong>{{ $booking->contact_phone }}</strong> to confirm and arrange payment.</p>
        <p>We look forward to hosting {{ $booking->group_name }}!</p>
        <p style="margin-top:20px">Warm regards,<br><strong>Eve Mountain Campsite Team</strong></p>
    </div>
    <div class="footer">
        <img src="{{ config('app.url') }}/images/logo.png" alt="Eve Mountain"><br>
        Eve Mountain Campsite · Zimbabwe · info@evemountain.co.zw
    </div>
</div>
</body>
</html>
