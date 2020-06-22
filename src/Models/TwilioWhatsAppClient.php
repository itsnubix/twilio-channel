<?php

namespace Nubix\Notifications\Models;

use Twilio\Rest\Client;

class TwilioWhatsAppClient
{

    /**
     * The Twilio Rest Client
     *
     * @var Twilio\Rest\Client
     */
    protected $client;


    /**
     * @var string The WhatsApp From number
     */
    protected $from;


    /**
     * TwilioWhatsAppClient constructor.
     * @param $from
     * @param $sid
     * @param $token
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function __construct($from, $sid, $token)
    {
        $this->from = $from;
        $this->client = new Client($sid, $token);
    }


    /**
     * @param $to  to WhatsApp number
     * @param $body  message body
     * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function createMessage($to, $body)
    {
        return $this->client->messages->create(
            $to,
            [
                "from" => $this->from,
                "body" => $body
            ]
        );
    }

}