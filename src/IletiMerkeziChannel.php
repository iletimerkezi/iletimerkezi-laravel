<?php

namespace IletiMerkezi\SMS;

use IletiMerkezi\IletiMerkeziClient;
use IletiMerkezi\Responses\SmsResponse;
use Illuminate\Notifications\Notification;

class IletiMerkeziChannel
{
    protected $client;
    protected $debug;

    public function __construct(IletiMerkeziClient $client)
    {
        $this->client = $client;
    }

    public function send($notifiable, Notification $notification): SmsResponse | null
    {
        $numbers[] = $notifiable->routeNotificationFor('iletimerkezi');
        if(count($numbers) === 0) {
            return null;
        }

        $message = $notification->toIletiMerkezi($notifiable);
        if (is_string($message)) {
            $message = new IletiMerkeziMessage($message);
        }

        $sms = $this->client->sms()->schedule($message->schedule_at ?? '');

        if($message->iys) {
            $sms->enableIysConsent()->iysList($message->iys_list);
        } else {
            $sms->disableIysConsent();
        }

        return $sms->send($numbers, $message->body, $message->sender ?? null);
    }
}