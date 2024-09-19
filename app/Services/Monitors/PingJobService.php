<?php

namespace App\Services\Monitors;

use App\Enums\ProtocolSocketType;
use App\Enums\RequestTimeoutInSecLength;
use App\Events\Ping\NotPingable;
use App\Events\Ping\Pingable;
use App\Models\Monitor;
use Exception;

class PingJobService implements MonitorServiceInterface
{
    protected int $timeoutInSec;

    public function __construct(protected Monitor $monitor, protected int $retryTimes = 1, protected ProtocolSocketType $socketType = ProtocolSocketType::BOTH, protected int $port = 80,)
    {
        $this->timeoutInSec = $this->monitor->parameter('request_timeout') ?? RequestTimeoutInSecLength::default();
    }

    public function run(): void
    {
        try {
            if (!pp_is_ip($this->monitor->endpoint)) {
                return;
            }

            $pingResultInSec = match ($this->socketType) {
                ProtocolSocketType::BOTH => nmap_service(
                    domain: $this->monitor->endpoint,
                    port: $this->port,
                    portType: ProtocolSocketType::BOTH,
                    timeoutInSec: $this->timeoutInSec,
                    maxRetries: $this->retryTimes,
                )->result->latencyInSeconds,

                ProtocolSocketType::TCP => nmap_service(
                    domain: $this->monitor->endpoint,
                    port: $this->port,
                    portType: ProtocolSocketType::TCP,
                    timeoutInSec: $this->timeoutInSec,
                    maxRetries: $this->retryTimes,
                )
                    ->result->latencyInSeconds,

                ProtocolSocketType::UDP => nmap_service(
                    domain: $this->monitor->endpoint,
                    port: $this->port,
                    portType: ProtocolSocketType::UDP,
                    timeoutInSec: $this->timeoutInSec,
                    maxRetries: $this->retryTimes,)
                    ->result->latencyInSeconds,
            };

            if (!$pingResultInSec) {
                event(new NotPingable($this->monitor));
            } else {
                $responseTimeText = json_encode(['response_in_sec' => $pingResultInSec]);
                event(new Pingable($this->monitor, $responseTimeText));
            }
        } catch (Exception $exception) {
            $response = $exception->getMessage();
            event(new NotPingable($this->monitor, $response));
        }
    }
}
