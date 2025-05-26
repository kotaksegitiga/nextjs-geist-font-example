@extends('layouts.adminlte')

@section('header', 'Admin Dashboard - Permintaan Persekot')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.export') }}" class="btn btn-success mb-3">Export Results</a>

    @if($requests->count())
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $request)
            <tr>
                <td>{{ $request->nama }}</td>
                <td>{{ $request->tanggal->format('Y-m-d') }}</td>
                <td>{{ number_format($request->total, 2) }}</td>
                <td class="text-capitalize">{{ $request->status }}</td>
                <td>
                    @if($request->status === 'pending')
                    <form action="{{ route('admin.persekot.approve', $request) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Approve</button>
                    </form>
                    <form action="{{ route('admin.persekot.reject', $request) }}" method="POST" style="display:inline-block; margin-left: 5px;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                    </form>
                    @else
                    <span>-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $requests->links() }}
    </div>
    @else
    <p>Tidak ada permintaan persekot.</p>
    @endif
@endsection
