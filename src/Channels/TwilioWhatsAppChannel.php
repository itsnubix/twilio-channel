<?php

namespace Nubix\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Nubix\Notifications\Messages\TwilioWhatsAppMessage;
use Nubix\Notifications\Models\TwilioWhatsAppClient;
use Twilio\Rest\Client;

class TwilioWhatsAppChannel
{

    /**
     * The Twilio Rest Client
     *
     * @var Nubix\Notifications\Models\TwilioWhatsAppClient
     */
    protected $client;


    public function __construct(TwilioWhatsAppClient $client)
    {
        $this->client = $client;
    }


    /**
     * @param $notifiable
     * @param Notification $notification
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance|void
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('twilio:whatsApp', $notification)) {
            return;
        }

        $message = $notification->toMessage($notifiable);

        if (is_string($message)) {
            $message = new TwilioWhatsAppMessage($message);
        }

        return $this->client->createMessage($to, $message->content);

    }
}