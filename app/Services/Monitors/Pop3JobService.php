<?php

namespace App\Services\Monitors;

use App\Events\Pop3Server\Pop3ServerDoesntWork;
use App\Events\Pop3Server\Pop3ServerWorks;
use App\Models\Monitor;
use App\Services\Tools\Pop3\Pop3Service;
use Exception;

readonly class Pop3JobService implements MonitorServiceInterface
{
    public function __construct(private Monitor $monitor)
    {
        //
    }

    public function run(): void
    {
        try {
            $service = new Pop3Service(
                host: $this->monitor->pop3Host(),
                user: $this->monitor->pop3User(),
                pass: $this->monitor->pop3Password(),
                timeout: $this->monitor->requestTimeout(),
                port: $this->monitor->pop3Port(),
                ssl: $this->monitor->pop3Ssl(),
                tls: $this->monitor->pop3Tls(),
            );

            $service->connect();

            $service->isLoggedIn()
                ? event(new Pop3ServerWorks($this->monitor))
                : event(new Pop3ServerDoesntWork($this->monitor));
        } catch (Exception $exception) {
            $response = $exception->getMessage();

            event(new Pop3ServerDoesntWork($this->monitor, $response));
        }
    }
}
