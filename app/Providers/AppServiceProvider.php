<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\MailManager;
use App\Mail\Transports\MailerSendSmtpTransport;

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
            $manager->extend('mailersend', function (array $config) {
                return new MailerSendSmtpTransport(
                    $config['host'] ?? 'smtp.mailersend.net',
                    $config['port'] ?? 587,
                    $config['encryption'] ?? 'tls',
                    $config['username'] ?? null,
                    $config['password'] ?? null
                );
            });
        });
    }
}
