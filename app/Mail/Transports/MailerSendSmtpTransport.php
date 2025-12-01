<?php

namespace App\Mail\Transports;

use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use App\Mail\Transports\MailerSendSocketStream;

class MailerSendSmtpTransport extends EsmtpTransport
{
    public function __construct(string $host = 'smtp.mailersend.net', int $port = 587, ?string $encryption = 'tls', ?string $username = null, ?string $password = null)
    {
        $stream = new MailerSendSocketStream();
        
        $stream->setHost($host);
        $stream->setPort($port);
        
        if ($encryption === 'tls' || $encryption === 'ssl') {
            $stream->setCrypto(true);
        }
        
        parent::__construct($stream, null);
        
        if ($username && $password) {
            $this->setUsername($username);
            $this->setPassword($password);
        }
    }
}

