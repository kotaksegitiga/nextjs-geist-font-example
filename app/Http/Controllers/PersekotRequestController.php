<?php

namespace App\Http\Controllers;

use App\Models\PersekotRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use PDF; // Assuming barryvdh/laravel-dompdf is installed

class PersekotRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // List requests for logged in user
    public function index()
    {
        $requests = Auth::user()->persekotRequests()->latest()->paginate(10);
        return view('persekot.index', compact('requests'));
    }

    // Show form to create new request
    public function create()
    {
        return view('persekot.create');
    }

    // Store new request
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jabatan' => 'required|string|max:255',
            'departemen' => 'required|string|max:255',
            'kantor' => 'required|string|max:255',
            'usage_details' => 'required|array|size:5',
            'usage_details.*.tanggal' => 'required|date',
            'usage_details.*.tujuan' => 'required|string|max:255',
            'usage_details.*.jumlah' => 'required|numeric|min:0',
        ]);

        $newTotal = collect($request->usage_details)->sum('jumlah');

        // Sum previous totals for the same 'nama'
        $previousTotal = PersekotRequest::where('nama', $request->nama)->sum('total');

        $total = $previousTotal + $newTotal;

        $persekotRequest = PersekotRequest::create([
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'jabatan' => $request->jabatan,
            'departemen' => $request->departemen,
            'kantor' => $request->kantor,
            'usage_details' => $request->usage_details,
            'total' => $total,
            'status' => 'pending',
        ]);

        return redirect()->route('persekot.index')->with('success', 'Persekot request submitted successfully.');
    }

    // Show details of a request
    public function show(PersekotRequest $persekotRequest)
    {
        $this->authorize('view', $persekotRequest);
        return view('persekot.show', compact('persekotRequest'));
    }

    // Export PDF of a request
    public function exportPdf(PersekotRequest $persekotRequest)
    {
        $this->authorize('view', $persekotRequest);

        $pdf = PDF::loadView('persekot.pdf', compact('persekotRequest'));
        return $pdf->download('persekot_request_' . $persekotRequest->id . '.pdf');
    }
}
