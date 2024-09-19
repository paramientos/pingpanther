<?php

namespace App\Services\Monitors;

use App\Enums\RequestTimeoutInSecLength;
use App\Events\HttpStatus\EndpointNotAccessible;
use App\Events\HttpStatus\EndpointAccessible;
use App\Models\Monitor;
use Exception;
use Http;

class HttpStatusJobService implements MonitorServiceInterface
{
    public int $timeout;
    public bool $saveResponse;

    public function __construct(public readonly Monitor $monitor, public readonly array $expectedStatusCodes, public readonly int $retryTimes = 1, public readonly string $method = 'GET', public readonly array $headers = [],)
    {
        $this->timeout = $this->monitor->parameter('request_timeout') ?? RequestTimeoutInSecLength::default();
        $this->saveResponse = (bool)$this->monitor->parameter('save_response_endpoint') ?? false;
    }

    public function run(): void
    {
        try {
            $request = Http::timeout($this->timeout)
                ->withHeaders(array_merge($this->headers, [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/61.0.3163.100 Safari/537.36'
                ]))
                ->retry($this->retryTimes)
                ->send($this->method, $this->monitor->endpoint);

            $responseInMs = ['response_in_sec' => ((float)number_format($request->transferStats->getTransferTime(), 5)) * 1000];

            $response = json_encode(array_merge($responseInMs, [
                'response' => $this->saveResponse
                    ? $request->json()
                    : ''
            ]));

            in_array($request->status(), $this->expectedStatusCodes)
                ? event(new EndpointAccessible($this, $response))
                : event(new EndpointNotAccessible($this, $request->json()));
        } catch (Exception $exception) {
            event(new EndpointNotAccessible($this, $exception->getMessage()));
        }
    }
}
