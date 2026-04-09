<?php

namespace App\Http\Controllers;

use App\Models\EmailSend;
use Illuminate\Http\Request;

class EmailHistoryController extends Controller
{
    /**
     * Display email send history
     */
    public function index()
    {
        $emailSends = EmailSend::with(['group', 'sender', 'recipients'])
            ->latest()
            ->paginate(20);

        return view('admin.email-history', compact('emailSends'));
    }

    /**
     * Show details of a specific email send
     */
    public function show($id)
    {
        $emailSend = EmailSend::with(['group', 'sender', 'recipients.user'])
            ->findOrFail($id);

        return view('admin.email-history-detail', compact('emailSend'));
    }

    /**
     * Purge all email history records (including sending).
     */
    public function purgeAll(Request $request)
    {
        try {
            $deletedCount = EmailSend::query()->delete();

            return redirect()
                ->route('admin.mailing-list.history')
                ->with('success', "Purged {$deletedCount} email history record(s).");
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.mailing-list.history')
                ->with('error', 'Failed to purge email history. Please try again.');
        }
    }
}
