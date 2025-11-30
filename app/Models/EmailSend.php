<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmailSend extends Model
{
    protected $fillable = [
        'group_id',
        'subject',
        'body',
        'sent_by',
        'total_recipients',
        'sent_count',
        'failed_count',
        'status',
        'errors',
        'sent_at',
    ];

    protected $casts = [
        'errors' => 'array',
        'sent_at' => 'datetime',
    ];

    /**
     * Get the group that this email was sent to.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the user who sent this email.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    /**
     * Get all recipients for this email send.
     */
    public function recipients(): HasMany
    {
        return $this->hasMany(EmailRecipient::class);
    }
}
