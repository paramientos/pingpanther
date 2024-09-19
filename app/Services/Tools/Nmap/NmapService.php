<?php

namespace App\Services\Tools\Nmap;

use App\Enums\ProtocolSocketType;


class NmapService
{
    public NmapPingResult $result;

    public function __construct(string $domain, int $port = 80, ProtocolSocketType $portType = ProtocolSocketType::BOTH, int $timeoutInSec = 10, int $maxRetries = 1)
    {
        $regexPattern = "/Nmap done: (\d+) IP address \((\d+) host (up|down)\) scanned in ([\d.]+) seconds/";

        $command = "nmap -Pn --max-retries {$maxRetries} --host-timeout {$timeoutInSec} {$portType->getNmapParameter()} -p {$port} {$domain}";

        exec($command, $output);

        preg_match($regexPattern, last($output), $matches);

        if (empty($matches) || count($matches) !== 5) {
            $this->result = new NmapPingResult(
                statusAsText: 'unreachable',
            );
        } else {
            $this->result = new NmapPingResult(
                count: $matches[2],
                statusAsText: $matches[3],
                latencyInSeconds: $matches[4],
            );
        }
    }

}
