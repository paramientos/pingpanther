<?php

namespace App\Services\Monitors;

use App\Events\SmtpServer\SmtpCanNotSendMail;
use App\Events\SmtpServer\SmtpCanSendMail;
use App\Models\Monitor;
use App\Services\Tools\Smtp\SmtpControlService;
use Exception;

readonly class SmtpJobService implements MonitorServiceInterface
{
    public function __construct(private Monitor $monitor)
    {
        //
    }

    public function run(): void
    {
        try {
            $service = new SmtpControlService(
                host: $this->monitor->endpoint,
                port: $this->monitor->smtpPort(),
                timeout: $this->monitor->requestTimeout(),
            );

            $response['response'] = $service->smtp->response();

            $ping = nmap_service(
                domain: $this->monitor->endpoint,
                port: $this->monitor->smtpPort(),
                timeoutInSec: $this->monitor->requestTimeout()
            );

            $response['response_in_sec'] = $ping->result->latencyInSeconds;

            $response = json_encode($response);

            $service->smtp->status()
                ? event(new SmtpCanSendMail($this->monitor, $response))
                : event(new SmtpCanNotSendMail($this->monitor, $response));

        } catch (Exception $exception) {
            $response = $exception->getMessage();

            event(new SmtpCanNotSendMail($this->monitor, $response));
        }
    }
}
