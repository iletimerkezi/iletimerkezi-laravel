<?php

namespace IletiMerkezi\SMS;

use IletiMerkezi\IletiMerkeziClient;
use IletiMerkezi\Services\SmsService;
use IletiMerkezi\Services\ReportService;
use IletiMerkezi\Services\SummaryService;
use IletiMerkezi\Services\SenderService;
use IletiMerkezi\Services\BlacklistService;
use IletiMerkezi\Services\AccountService;
use IletiMerkezi\Services\WebhookService;

class IletiMerkezi 
{
    protected $client;

    public function __construct(IletiMerkeziClient $client)
    {
        $this->client = $client;
    }

    public function sms(): SmsService
    {
        return $this->client->sms();
    }

    public function reports(): ReportService
    {
        return $this->client->reports();
    }
    
    public function summary(): SummaryService
    {
        return $this->client->summary();
    }

    public function senders(): SenderService
    {
        return $this->client->senders();
    }

    public function blacklist(): BlacklistService
    {
        return $this->client->blacklist();
    }

    public function account(): AccountService
    {
        return $this->client->account();
    }

    public function webhook(): WebhookService
    {
        return $this->client->webhook();
    }
    
    public function debug(): string
    {
        return $this->client->debug();
    }
}