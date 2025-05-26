@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Formulir Permintaan Persekot</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('persekot.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama" class="block font-semibold">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="tanggal" class="block font-semibold">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="jabatan" class="block font-semibold">Jabatan</label>
            <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="departemen" class="block font-semibold">Departemen</label>
            <input type="text" name="departemen" id="departemen" value="{{ old('departemen') }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="kantor" class="block font-semibold">Kantor</label>
            <input type="text" name="kantor" id="kantor" value="{{ old('kantor') }}" class="border p-2 w-full" required>
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
                @for ($i = 0; $i < 5; $i++)
                <tr>
                    <td class="border p-2 text-center">{{ $i + 1 }}</td>
                    <td class="border p-2">
                        <input type="date" name="usage_details[{{ $i }}][tanggal]" class="w-full p-1 border" value="{{ old('usage_details.' . $i . '.tanggal') }}">
                    </td>
                    <td class="border p-2">
                        <input type="text" name="usage_details[{{ $i }}][tujuan]" class="w-full p-1 border" value="{{ old('usage_details.' . $i . '.tujuan') }}">
                    </td>
                    <td class="border p-2">
                        <input type="number" name="usage_details[{{ $i }}][jumlah]" class="w-full p-1 border" step="0.01" value="{{ old('usage_details.' . $i . '.jumlah') }}">
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit</button>
    </form>
</div>
@endsection
