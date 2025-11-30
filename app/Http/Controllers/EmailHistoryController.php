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
}
