<?php

namespace App\Services\Monitors;

use App\Enums\DnsTypes;
use App\Events\DnsServer\Matched;
use App\Events\DnsServer\Unmatched;
use App\Models\Monitor;
use Exception;
use Spatie\Dns\Dns;
use Spatie\Dns\Records\Record;

class DnsServerJobService implements MonitorServiceInterface
{
    public ?string $response;

    public function __construct(public readonly Monitor $monitor, public DnsTypes $dnsType, public ?array $expectedValues)
    {
        //
    }

    public function run(): void
    {
        $dns = new Dns();
        $actualValues = [];

        try {
            $records = $dns->getRecords($this->monitor->endpoint, $this->dnsType->value);

            $valueMethodName = $this->dnsType->valueMethodName();

            /** @var Record[] $records */
            foreach ($records as $record) {
                $actualValues[] = $record->{$valueMethodName}();
            }

            $diff = array_diff($actualValues, $this->expectedValues);

            empty($diff)
                ? event(new Matched($this->monitor))
                : event(new Unmatched($this->monitor));
        } catch (Exception $exception) {
            $response = $exception->getMessage();

            event(new Unmatched($this->monitor, $response));
        }
    }
}
