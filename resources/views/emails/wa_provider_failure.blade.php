<p>Dear Admin,</p>

<p>There have been repeated WhatsApp provider rejections for the following target:</p>

<ul>
    <li><strong>Kunjungan ID:</strong> {{ $kunjungan_id ?? 'n/a' }}</li>
    <li><strong>Target:</strong> {{ $target ?? 'n/a' }}</li>
    <li><strong>Original:</strong> {{ $original ?? 'n/a' }}</li>
    <li><strong>Attempts:</strong> {{ $attempts ?? 'n/a' }}</li>
    <li><strong>Request ID:</strong> {{ $requestid ?? 'n/a' }}</li>
</ul>

<p><strong>Provider Response:</strong></p>
<pre>{{ $response ?? 'no response' }}</pre>

<p><strong>Reason:</strong> {{ $reason ?? 'unknown' }}</p>

<p>Please check the provider account or connected device (the provider responded with "request invalid on disconnected device" in many recent calls).</p>

<p>Regards,<br/>Lapas App</p>