@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Detail Permintaan Persekot</h1>

    <div class="mb-4">
        <strong>Nama:</strong> {{ $persekotRequest->nama }}<br>
        <strong>Tanggal:</strong> {{ $persekotRequest->tanggal->format('Y-m-d') }}<br>
        <strong>Jabatan:</strong> {{ $persekotRequest->jabatan }}<br>
        <strong>Departemen:</strong> {{ $persekotRequest->departemen }}<br>
        <strong>Kantor:</strong> {{ $persekotRequest->kantor }}<br>
        <strong>Status:</strong> <span class="capitalize">{{ $persekotRequest->status }}</span><br>
        @if($persekotRequest->approval_note)
        <strong>Catatan Persetujuan:</strong> {{ $persekotRequest->approval_note }}<br>
        @endif
    </div>

    <h2 class="text-xl font-semibold mb-2">Detail Penggunaan Dana</h2>
    <table class="w-full border border-collapse mb-4">
        <thead>
            <tr>
                <th class="border p-2">No</th>
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Tujuan Penggunaan Dana</th>
                <th class="border p-2">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($persekotRequest->usage_details as $index => $detail)
            <tr>
                <td class="border p-2 text-center">{{ $index + 1 }}</td>
                <td class="border p-2">{{ $detail['tanggal'] ?? '-' }}</td>
                <td class="border p-2">{{ $detail['tujuan'] ?? '-' }}</td>
                <td class="border p-2">{{ number_format($detail['jumlah'] ?? 0, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mb-4">
        <strong>Total:</strong> {{ number_format($persekotRequest->total, 2) }}
    </div>

    @if($persekotRequest->status === 'approved')
        <div class="mb-4">
            <strong>Approval Barcode:</strong><br>
            {!! DNS2D::getBarcodeSVG('PersekotID:' . $persekotRequest->id . '-ApprovedAt:' . $persekotRequest->updated_at, 'QRCODE', 4, 4) !!}
        </div>
    @endif

    <a href="{{ url()->previous() }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Kembali</a>

    <a href="{{ route('persekot.exportPdf', $persekotRequest) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Download PDF</a>
</div>
@endsection
