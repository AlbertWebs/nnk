<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\MailManager;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Fix SSL certificate verification for MailerSend SMTP when hosting intercepts connections
        // This is a workaround for hosting providers that intercept SMTP traffic
        $this->app->afterResolving(MailManager::class, function (MailManager $manager) {
            $manager->extend('mailersend', function (array $config) use ($manager) {
                // Create SMTP transport
                $transport = $manager->createTransport([
                    'transport' => 'smtp',
                    'host' => $config['host'] ?? 'smtp.mailersend.net',
                    'port' => $config['port'] ?? 587,
                    'username' => $config['username'] ?? null,
                    'password' => $config['password'] ?? null,
                    'encryption' => $config['encryption'] ?? 'tls',
                ]);
                
                // Disable SSL verification if hosting provider intercepts SMTP connections
                if ($transport instanceof EsmtpTransport) {
                    $stream = $transport->getStream();
                    if (method_exists($stream, 'setStreamOptions')) {
                        $stream->setStreamOptions([
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true,
                            ],
                        ]);
                    } elseif (method_exists($stream, 'setContext')) {
                        $context = stream_context_create([
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true,
                            ],
                        ]);
                        $stream->setContext($context);
                    }
                }
                
                return $transport;
            });
        });
    }
}
