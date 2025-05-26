<!DOCTYPE html>
<html>
<head>
    <title>Persekot Request Approved</title>
</head>
<body>
    <h1>Persekot Request Approved</h1>
    <p>Dear {{ $persekotRequest->nama }},</p>
    <p>Your Persekot request submitted on {{ $persekotRequest->tanggal->format('Y-m-d') }} has been approved.</p>
    <p><strong>Total Amount:</strong> {{ number_format($persekotRequest->total, 2) }}</p>
    <p>Thank you for using our system.</p>
</body>
</html>
