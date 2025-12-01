<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\MailManager;
use App\Mail\Transports\MailerSendApiTransport;

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
        // Register MailerSend API transport
        $this->app->afterResolving(MailManager::class, function (MailManager $manager) {
            $manager->extend('mailersend', function (array $config) {
                $apiKey = $config['api_key'] ?? config('services.mailersend.api_key');
                
                if (empty($apiKey)) {
                    throw new \InvalidArgumentException('MailerSend API key is required');
                }
                
                return new MailerSendApiTransport($apiKey);
            });
        });
    }
}
