<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { font-family: Arial, sans-serif; font-size: 14px; color: #374151; background: #f9fafb; margin: 0; }
.wrap { max-width: 520px; margin: 32px auto; background: #fff; border-radius: 12px; overflow: hidden; }
.header { padding: 28px 32px; color: white; background: {{ $booking->status === 'confirmed' ? '#1a7849' : '#dc2626' }}; }
.body { padding: 28px 32px; }
</style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <h2 style="margin:0;font-size:18px">
            Booking {{ $booking->status === 'confirmed' ? 'Confirmed ✓' : 'Cancelled' }}
        </h2>
        <p style="margin:4px 0 0;opacity:.8;font-size:13px">{{ $booking->reference }} · Eve Mountain Campsite</p>
    </div>
    <div class="body">
        <p>Dear {{ $booking->contact_name }},</p>

        @if($booking->status === 'confirmed')
        <p>Your booking for <strong>{{ $booking->group_name }}</strong> has been <strong>confirmed</strong>. We look forward to welcoming you!</p>
        <p><strong>Arrival:</strong> {{ $booking->arrival_date->format('D, d M Y') }}<br>
           <strong>Departure:</strong> {{ $booking->departure_date->format('D, d M Y') }}<br>
           <strong>Guests:</strong> {{ $booking->pax_count }}<br>
           <strong>Total:</strong> US${{ number_format($booking->total_quote, 2) }}</p>
        <p>Please contact us at <a href="mailto:info@evemountain.co.zw">info@evemountain.co.zw</a> for payment and directions.</p>
        @else
        <p>We regret to inform you that your booking <strong>{{ $booking->reference }}</strong> for {{ $booking->group_name }} has been cancelled.</p>
        @if($booking->admin_notes)
        <p><strong>Reason:</strong> {{ $booking->admin_notes }}</p>
        @endif
        <p>If you believe this is an error or would like to rebook, please contact us at <a href="mailto:info@evemountain.co.zw">info@evemountain.co.zw</a>.</p>
        @endif

        <p style="margin-top:24px">Warm regards,<br><strong>Eve Mountain Campsite</strong></p>
    </div>
</div>
</body>
</html>
