<?php

namespace App\Http\Controllers;

use App\Models\PersekotRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:admin']);
    }

    // List all persekot requests
    public function index()
    {
        $requests = PersekotRequest::latest()->paginate(15);
        return view('admin.index', compact('requests'));
    }

    // Approve a request
    public function approve(Request $request, PersekotRequest $persekotRequest)
    {
        $persekotRequest->status = 'approved';
        $persekotRequest->approval_note = $request->input('approval_note', '');
        $persekotRequest->save();

        // Send WhatsApp notification
        $this->sendWhatsAppNotification($persekotRequest);

        // Send Email notification
        $this->sendEmailNotification($persekotRequest);

        return redirect()->back()->with('success', 'Request approved and notifications sent.');
    }

    // Reject a request
    public function reject(Request $request, PersekotRequest $persekotRequest)
    {
        $persekotRequest->status = 'rejected';
        $persekotRequest->approval_note = $request->input('approval_note', '');
        $persekotRequest->save();

        return redirect()->back()->with('success', 'Request rejected.');
    }

    // Export all requests as CSV
    public function export()
    {
        $filename = 'persekot_requests_' . date('Ymd_His') . '.csv';
        $requests = PersekotRequest::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = ['ID', 'Nama', 'Tanggal', 'Jabatan', 'Departemen', 'Kantor', 'Total', 'Status', 'Created At'];

        $callback = function () use ($requests, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($requests as $request) {
                fputcsv($file, [
                    $request->id,
                    $request->nama,
                    $request->tanggal->format('Y-m-d'),
                    $request->jabatan,
                    $request->departemen,
                    $request->kantor,
                    $request->total,
                    $request->status,
                    $request->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Send WhatsApp notification (placeholder implementation)
    protected function sendWhatsAppNotification(PersekotRequest $request)
    {
        // Example using Twilio API or other WhatsApp API
        // You need to configure your API credentials in .env and services.php

        $message = "Persekot request approved for {$request->nama} on {$request->tanggal->format('Y-m-d')}. Total: {$request->total}";

        // Example HTTP POST to WhatsApp API endpoint
        // Replace with actual API call and parameters

        $phoneNumber = $request->user->phone ?? null; // Assuming user has phone attribute

        if ($phoneNumber) {
            Http::post('https://api.whatsapp.example/send', [
                'to' => $phoneNumber,
                'message' => $message,
            ]);
        }
    }

    // Send Email notification on approval
    protected function sendEmailNotification(PersekotRequest $request)
    {
        $user = $request->user;
        if (!$user || !$user->email) {
            return;
        }

        \Mail::to($user->email)->send(new \App\Mail\PersekotApproved($request));
    }
}
