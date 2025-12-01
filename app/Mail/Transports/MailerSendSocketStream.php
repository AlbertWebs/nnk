<?php

namespace App\Mail\Transports;

use Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream;
use Symfony\Component\Mailer\Exception\TransportException;

class MailerSendSocketStream extends SocketStream
{
    public function __construct()
    {
        parent::__construct();
        
        // Set stream context options to disable SSL verification
        // This property is used by the parent class in initialize()
        $reflection = new \ReflectionClass($this);
        if ($reflection->hasProperty('streamContextOptions')) {
            $property = $reflection->getProperty('streamContextOptions');
            $property->setAccessible(true);
            $property->setValue($this, [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]);
        }
    }
    
    /**
     * Override startTLS to ensure SSL context is set before enabling crypto
     */
    public function startTLS(): bool
    {
        // Get the stream resource and ensure SSL context is set
        $reflection = new \ReflectionClass($this);
        if ($reflection->hasProperty('stream')) {
            $streamProperty = $reflection->getProperty('stream');
            $streamProperty->setAccessible(true);
            $stream = $streamProperty->getValue($this);
            
            if (is_resource($stream)) {
                // Ensure SSL context options are set on the stream
                stream_context_set_option($stream, 'ssl', 'verify_peer', false);
                stream_context_set_option($stream, 'ssl', 'verify_peer_name', false);
                stream_context_set_option($stream, 'ssl', 'allow_self_signed', true);
            }
        }
        
        // Use custom error handler that suppresses certificate errors
        set_error_handler(function ($type, $msg) {
            // Suppress certificate mismatch errors
            if (strpos($msg, 'Peer certificate') !== false || 
                strpos($msg, 'certificate') !== false ||
                strpos($msg, 'did not match') !== false) {
                return true; // Suppress the error
            }
            throw new TransportException('Unable to connect with STARTTLS: '.$msg);
        });
        
        try {
            return stream_socket_enable_crypto($this->stream, true);
        } catch (\Exception $e) {
            // If it's a certificate error, try again with context explicitly set
            if (strpos($e->getMessage(), 'certificate') !== false || 
                strpos($e->getMessage(), 'did not match') !== false) {
                $reflection = new \ReflectionClass($this);
                if ($reflection->hasProperty('stream')) {
                    $streamProperty = $reflection->getProperty('stream');
                    $streamProperty->setAccessible(true);
                    $stream = $streamProperty->getValue($this);
                    
                    if (is_resource($stream)) {
                        stream_context_set_option($stream, 'ssl', 'verify_peer', false);
                        stream_context_set_option($stream, 'ssl', 'verify_peer_name', false);
                        stream_context_set_option($stream, 'ssl', 'allow_self_signed', true);
                        
                        // Try again with suppressed errors
                        set_error_handler(function () {
                            return true; // Suppress all errors
                        });
                        try {
                            return stream_socket_enable_crypto($stream, true);
                        } finally {
                            restore_error_handler();
                        }
                    }
                }
            }
            throw $e;
        } finally {
            restore_error_handler();
        }
    }
}

