<?php

namespace App\Mail\Transports;

use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Exception\TransportException;
use Illuminate\Support\Facades\Http;

class MailerSendApiTransport extends AbstractTransport
{
    private string $apiKey;
    private const API_URL = 'https://api.mailersend.com/v1/email';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        try {
            $originalMessage = $message->getOriginalMessage();
            
            // Get from address
            $from = $originalMessage->getFrom();
            $fromAddress = $from[0]->getAddress();
            $fromName = $from[0]->getName() ?: config('mail.from.name');
            
            // Get to addresses
            $to = $originalMessage->getTo();
            $recipients = [];
            foreach ($to as $address) {
                $recipients[] = [
                    'email' => $address->getAddress(),
                    'name' => $address->getName() ?: '',
                ];
            }
            
            // Get CC addresses
            $cc = $originalMessage->getCc();
            $ccRecipients = [];
            if ($cc) {
                foreach ($cc as $address) {
                    $ccRecipients[] = [
                        'email' => $address->getAddress(),
                        'name' => $address->getName() ?: '',
                    ];
                }
            }
            
            // Get BCC addresses
            $bcc = $originalMessage->getBcc();
            $bccRecipients = [];
            if ($bcc) {
                foreach ($bcc as $address) {
                    $bccRecipients[] = [
                        'email' => $address->getAddress(),
                        'name' => $address->getName() ?: '',
                    ];
                }
            }
            
            // Get subject
            $subject = $originalMessage->getSubject();
            
            // Get body
            $html = $originalMessage->getHtmlBody();
            $text = $originalMessage->getTextBody();
            
            // Handle attachments
            $attachments = [];
            foreach ($originalMessage->getAttachments() as $attachment) {
                $body = $attachment->getBody();
                $filename = $attachment->getFilename();
                $contentType = $attachment->getContentType();
                
                // If body is a resource, read it
                if (is_resource($body)) {
                    $content = stream_get_contents($body);
                } else {
                    $content = $body;
                }
                
                $attachments[] = [
                    'content' => base64_encode($content),
                    'filename' => $filename,
                    'type' => $contentType,
                ];
            }
            
            // Build payload
            $payload = [
                'from' => [
                    'email' => $fromAddress,
                    'name' => $fromName,
                ],
                'to' => $recipients,
                'subject' => $subject,
            ];
            
            if (!empty($ccRecipients)) {
                $payload['cc'] = $ccRecipients;
            }
            
            if (!empty($bccRecipients)) {
                $payload['bcc'] = $bccRecipients;
            }
            
            if ($html) {
                $payload['html'] = $html;
            }
            
            if ($text) {
                $payload['text'] = $text;
            }
            
            if (!empty($attachments)) {
                $payload['attachments'] = $attachments;
            }
            
            // Send email via MailerSend API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
            ])->post(self::API_URL, $payload);
            
            if (!$response->successful()) {
                $error = $response->json();
                throw new TransportException(
                    'MailerSend API error: ' . ($error['message'] ?? $response->body() ?? 'Unknown error'),
                    $response->status()
                );
            }
            
        } catch (TransportException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new TransportException('Failed to send email via MailerSend API: ' . $e->getMessage(), 0, $e);
        }
    }

    public function __toString(): string
    {
        return 'mailersend';
    }
}

