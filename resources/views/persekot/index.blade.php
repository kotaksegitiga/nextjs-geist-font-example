 @extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Daftar Permintaan Persekot Saya</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('persekot.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">Buat Permintaan Baru</a>

    @if($requests->count())
    <table class="w-full border border-collapse">
        <thead>
            <tr>
                <th class="border p-2">Tanggal</th>
                <th class="border p-2">Nama</th>
                <th class="border p-2">Total</th>
                <th class="border p-2">Status</th>
                <th class="border p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td class="border p-2">{{ $request->tanggal->format('Y-m-d') }}</td>
                <td class="border p-2">{{ $request->nama }}</td>
                <td class="border p-2">{{ number_format($request->total, 2) }}</td>
                <td class="border p-2 capitalize">{{ $request->status }}</td>
                <td class="border p-2">
                    <a href="{{ route('persekot.show', $request) }}" class="text-blue-600 hover:underline">Lihat</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $requests->links() }}
    </div>
    @else
    <p>Tidak ada permintaan persekot.</p>
    @endif
</div>
@endsection
