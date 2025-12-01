<?php

namespace App\Mail\Transports;

use Symfony\Component\Mailer\Transport\Smtp\Stream\SocketStream;

class MailerSendSocketStream extends SocketStream
{
    public function initialize(): void
    {
        // Set SSL context before initializing connection
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);
        
        // Use reflection to set context
        $reflection = new \ReflectionClass($this);
        foreach (['context', 'streamContext'] as $propName) {
            if ($reflection->hasProperty($propName)) {
                $property = $reflection->getProperty($propName);
                $property->setAccessible(true);
                $property->setValue($this, $context);
                break;
            }
        }
        
        parent::initialize();
    }
}

