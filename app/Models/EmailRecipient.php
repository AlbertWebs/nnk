<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailRecipient extends Model
{
    protected $fillable = [
        'email_send_id',
        'user_id',
        'recipient_email',
        'recipient_name',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    /**
     * Get the email send record.
     */
    public function emailSend(): BelongsTo
    {
        return $this->belongsTo(EmailSend::class);
    }

    /**
     * Get the user recipient.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
