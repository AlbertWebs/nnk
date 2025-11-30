<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GroupEmail extends Mailable
{
    use Queueable, SerializesModels;

    private string $emailSubject;
    public string $body;
    public string $recipientName;
    private array $emailAttachments;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subject, string $body, string $recipientName = '', array $attachments = [])
    {
        $this->emailSubject = $subject;
        $this->body = $body;
        $this->recipientName = $recipientName;
        $this->emailAttachments = $attachments;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.group-email',
            with: [
                'body' => $this->body,
                'recipientName' => $this->recipientName,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachmentObjects = [];
        
        foreach ($this->emailAttachments as $attachment) {
            if (Storage::disk('public')->exists($attachment['path'])) {
                $attachmentObjects[] = Attachment::fromStorageDisk('public', $attachment['path'])
                    ->as($attachment['name'])
                    ->withMime($attachment['mime'] ?? 'application/octet-stream');
            }
        }
        
        return $attachmentObjects;
    }
}
