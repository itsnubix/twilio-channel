<?php


use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Nubix\Notifications\Channels\TwilioWhatsAppChannel;
use Nubix\Notifications\Messages\TwilioWhatsAppMessage;
use Nubix\Notifications\Models\TwilioWhatsAppClient;
use PHPUnit\Framework\TestCase;

class ChannelTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /** @test */
    function message_is_sent_via_twilio_whatsapp()
    {


        $notifiable = new TestNotifiable();
        $notification = new TestNotification();
        $channel = new TwilioWhatsAppChannel($twilioClient = Mockery::mock(TwilioWhatsAppClient::class));



        $twilioClient->shouldReceive('createMessage')
            ->with( $notifiable->phone_number, $notification->message . 'a');

        $channel->send($notifiable, $notification);

    }
}

class TestNotifiable
{
    use Notifiable;

    public $phone_number = 'whatsapp+13215551234';
}

class TestNotification extends Notification
{
    public $message = 'test message';

    public function toMessage()
    {
        return new TwilioWhatsAppMessage($this->message);
    }
}
