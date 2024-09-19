<?php

namespace App\Services\DomainReg;

use App\Dto\DomainRegistration\SSLDto;
use Exception;
use Spatie\SslCertificate\SslCertificate;

class SSLInfo
{
    protected ?SSLDto $sslData = null;

    public function __construct(private readonly string $url)
    {
        try {
            $domain = url_to_domain($this->url);

            $certificate = SslCertificate::createForHostName($domain);

            $this->sslData = new SSLDto(
                url: $this->url,
                domainName: $domain,
                isValid: $certificate->isValid(),
                issuerName: $certificate->getIssuer(),
                validFrom: $certificate->validFromDate(),
                validTo: $certificate->expirationDate(),
                remainDays: $certificate->daysUntilExpirationDate(),
            );
        } catch (Exception) {
            //
        }
    }

    public function info(): ?SSLDto
    {
        return $this->sslData;
    }

    public function isExpired(int $dayBefore): bool
    {
        return $this->sslData->willExpire($dayBefore);
    }
}
