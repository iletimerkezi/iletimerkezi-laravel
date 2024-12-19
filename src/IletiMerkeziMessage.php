<?php

namespace IletiMerkezi\SMS;

use Carbon\Carbon;

class IletiMerkeziMessage
{
    public $iys = false;
    public $iys_list = 'BIREYSEL'; 
    public $body;
    public $sender;
    public $schedule_at;

    public static function create(string $body = ''): self
    {
        return new static($body);
    }

    public function __construct(string $body)
    {
        $this->body = $body;
    }

    public function setIys(bool $consent, string $list): self
    {
        $this->iys = $consent;
        $this->iys_list = $list;

        return $this;
    }

    public function setBody(string $value): self
    {
        $this->body = $value;

        return $this;
    }

    public function setSender(string $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    public function sendAt(Carbon $value): self
    {
        $this->schedule_at = $value->format('d/m/Y H:i');

        return $this;
    }
}