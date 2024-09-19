<?php

namespace App\Services\Monitors;

use App\Events\ImapServer\ImapServerDoesntWork;
use App\Events\ImapServer\ImapServerWorks;
use App\Models\Monitor;
use App\Services\Tools\Imap\ImapService;
use Exception;

readonly class ImapJobService implements MonitorServiceInterface
{
    public function __construct(private Monitor $monitor)
    {
        //
    }

    public function run(): void
    {
        try {

            $service = new ImapService(
                host: $this->monitor->imapHost(),
                user: $this->monitor->imapUser(),
                pass: $this->monitor->imapPassword(),
                timeout: $this->monitor->requestTimeout(),
                port: $this->monitor->imapPort(),
                ssl: $this->monitor->imapSsl(),
                tls: $this->monitor->imapTls(),
            );

            $service->connect();

            $service->isLoggedIn()
                ? event(new ImapServerWorks($this->monitor))
                : event(new ImapServerDoesntWork($this->monitor));
        } catch (Exception $exception) {
            $response = $exception->getMessage();

            event(new ImapServerDoesntWork($this->monitor, $response));
        }
    }
}
