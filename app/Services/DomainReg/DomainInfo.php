<?php

namespace App\Services\DomainReg;

use App\Dto\DomainRegistration\DomainDto;
use Exception;
use Iodev\Whois\Factory;

readonly class DomainInfo
{
    public function __construct(private string $url)
    {
    }

    public function get(): ?DomainDto
    {
        try {
            $whois = Factory::get()->createWhois();

            $domain = url_to_domain($this->url, returnRegistrableDomain: true);

            $info = $whois->loadDomainInfo($domain);

            if (!$info) {
                return null;
            }

            $values = $info?->toArray();

            extract($values);

            if (empty($nameServers)) {
                $nameServers = get_name_servers($domain);
            }

            return new DomainDto(
                $domainName, $whoisServer, $nameServers, $creationDate, $expirationDate, $updatedDate, $owner, $registrar, $dnssec
            );
        } catch (Exception) {
            //
        }

        return null;
    }

    public function isExpired($dayBefore): bool
    {
        return $this->get()->willExpire($dayBefore);
    }
}
