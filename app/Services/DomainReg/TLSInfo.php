<?php

namespace App\Services\DomainReg;

use App\Dto\DomainRegistration\TLSDto;
use Exception;

class TLSInfo
{
    protected ?TLSDto $tlsDto = null;

    public function __construct(private readonly string $url)
    {
        try {
            $ch = curl_init($this->url);
            $out = fopen('php://temp', 'w+');

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch, CURLOPT_STDERR, $out);
            curl_exec($ch);
            curl_close($ch);
            rewind($out);

            $debug = stream_get_contents($out);

            $domain = url_to_domain($this->url);

            if (preg_match('/SSL connection.*/', $debug, $match)) {
                $this->tlsDto = new TLSDto(domainName: $domain, isVerified: true, result: $match[0]);
            }
        } catch (Exception) {
            //
        }
    }

    public function info(): ?TLSDto
    {
        return $this->tlsDto;
    }

    public function isVerified(): bool
    {
        return $this->tlsDto->isVerified();
    }

    public function isUnverified(): bool
    {
        return !$this->tlsDto->isVerified();
    }

    public function getColor(): string
    {
        return $this->isVerified() ? 'green' : 'red';
    }
}
