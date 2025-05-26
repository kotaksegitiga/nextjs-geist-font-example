<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Persekot Request PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 6px;
            text-align: left;
        }
        .title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
            text-align: center;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 40px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
            padding-right: 50px;
        }
        .signature {
            margin-top: 60px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('logo.png') }}" alt="Daniswara Group Logo">
        <div class="title">Formulir Permintaan Persekot</div>
    </div>

    <table>
        <tr>
            <td><strong>Nama</strong></td>
            <td>{{ $persekotRequest->nama }}</td>
            <td><strong>Tanggal</strong></td>
            <td>{{ $persekotRequest->tanggal->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td><strong>Jabatan</strong></td>
            <td>{{ $persekotRequest->jabatan }}</td>
            <td><strong>Departemen</strong></td>
            <td>{{ $persekotRequest->departemen }}</td>
        </tr>
        <tr>
            <td><strong>Kantor</strong></td>
            <td colspan="3">{{ $persekotRequest->kantor }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Tujuan Penggunaan Dana</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($persekotRequest->usage_details as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail['tanggal'] ?? '-' }}</td>
                <td>{{ $detail['tujuan'] ?? '-' }}</td>
                <td>{{ number_format($detail['jumlah'] ?? 0, 2) }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                <td><strong>{{ number_format($persekotRequest->total, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div>
            Depok, {{ $persekotRequest->tanggal->format('Y') }}<br>
            Dibuat Oleh<br><br><br>
            <div class="signature">(...................................)</div>
            @if($persekotRequest->status === 'approved')
                <div style="margin-top: 20px;">
                    {!! DNS2D::getBarcodeSVG('PersekotID:' . $persekotRequest->id . '-ApprovedAt:' . $persekotRequest->updated_at, 'QRCODE', 4, 4) !!}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
