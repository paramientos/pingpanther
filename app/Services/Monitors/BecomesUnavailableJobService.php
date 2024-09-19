<?php

namespace App\Services\Monitors;

use App\Enums\RequestTimeoutInSecLength;
use App\Events\BecomesUnavailable\DomainDown;
use App\Events\BecomesUnavailable\DomainExpires;
use App\Events\BecomesUnavailable\DomainUp;
use App\Events\BecomesUnavailable\SSLExpires;
use App\Events\BecomesUnavailable\TLSUnverified;
use App\Events\BecomesUnavailable\TLSVerified;
use App\Models\Monitor;
use Exception;
use Http;

class BecomesUnavailableJobService implements MonitorServiceInterface
{
    protected int $timeout;

    public function __construct(protected Monitor $monitor, protected int $retryTimes = 1, protected string $method = 'GET', protected array $headers = [])
    {
        $this->timeout = $this->monitor->parameter('request_timeout') ?? RequestTimeoutInSecLength::default();
    }

    public function run(): void
    {
        try {
            if (pp_is_ip($this->monitor->endpoint)) {
                $pingResultInMs = get_response_time_from_ping($this->monitor->endpoint, $this->timeout, $this->retryTimes);

                if (!$pingResultInMs) {
                    event(new DomainDown($this->monitor));
                } else {
                    $responseTimeText = json_encode(['response_in_sec' => $pingResultInMs]);
                    event(new DomainUp($this->monitor, $responseTimeText));
                }
            } else {
                $this->runWithHttp();
            }
        } catch (Exception $exception) {
            $response = $exception->getMessage();
            event(new DomainDown($this->monitor, $response));
        }
    }

    /*
     * See Curl write-out variables here:
     * https://everything.curl.dev/usingcurl/verbose/writeout
     */
    public function runWithHttp(): void
    {
        try {
            $request = Http::timeout($this->timeout)
                ->withHeaders(array_merge($this->headers, [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'
                ]))
                ->retry($this->retryTimes)
                ->send($this->method, $this->monitor->endpoint);

            $responseTimeText = json_encode(['response_in_sec' => ((float)number_format($request->transferStats->getTransferTime(), 5)) * 1000]);

            $request->successful()
                ? event(new DomainUp($this->monitor, $responseTimeText))
                : event(new DomainDown($this->monitor));
        } catch (Exception $exception) {
            $response = $exception->getMessage();
            event(new DomainDown($this->monitor, $response));
        }
    }

    public function checkDomainExpiration()
    {
        $info = $this->monitor->domainInfo();

        event(new DomainExpires($this->monitor, $info));
    }

    public function checkSSLExpiration()
    {
        $certificate = $this->monitor->sslInfo();

        event(new SSLExpires($this->monitor, $certificate));
    }

    public function checkTLSVerification()
    {
        $result = $this->monitor->tlsInfo();

        empty($result)
            ? event(new TLSUnverified($this->monitor))
            : event(new TLSVerified($this->monitor, $result));
    }
}
