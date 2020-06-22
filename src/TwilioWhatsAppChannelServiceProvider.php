<?php

namespace Nubix\Notifications;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Nubix\Notifications\Channels\TwilioWhatsAppChannel;
use Nubix\Notifications\Models\TwilioWhatsAppClient;

class TwilioWhatsAppChannelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('twilio:whatsApp', function ($app) {

                return new TwilioWhatsAppChannel(
                    new TwilioWhatsAppClient(
                        $this->app['config']['services.twilio.from'],
                        $this->app['config']['services.twilio.sid'],
                        $this->app['config']['services.twilio.token']
                    )
                );
            });
        });
    }

}