<?php

namespace App\Enums;

use App\Concerns\EnumToArray;

enum DnsTypes: string
{
    use EnumToArray;

    case A = 'A';
    case AAAA = 'AAAA';
    case CNAME = 'CNAME';
    case NS = 'NS';
    case PTR = 'PTR';
    case SOA = 'SOA';
    case MX = 'MX';
    case SRV = 'SRV';
    case TXT = 'TXT';
    case CAA = 'CAA';

    public function default(): self
    {
        return self::A;
    }

    public function text(): string
    {
        return match ($this) {
            self::A => 'A record shows the IP address for a specific hostname or domain',
            self::AAAA => 'AAAA record, just like A record, point to the IP address for a domain. However, this DNS record type is different in the sense that it points to IPV6 addresses',
            self::CNAME => "CNAME (canonical name) is a DNS record that points a domain name (an alias) to another domain. In a CNAME record, the alias doesn't point to an IP address",
            self::NS => 'NS record helps point to where internet applications like a web browser can find the IP address for a domain name',
            self::PTR => 'PTR-records are primarily used as "reverse records" - to map IP addresses to domain names (reverse of A-records and AAAA-records)',
            self::SOA => 'SOA record states that authority for a zone is starting at a particular point in the global tree of DNS names',
            self::MX => 'MX (mail exchange) record, is a DNS record type that shows where emails for a domain should be routed to. In other words, an MX record makes it possible to direct emails to a mail server',
            self::SRV => 'SRV (service locator) DNS record type enables service discovery in the DNS',
            self::TXT => 'TXT (descriptive text) record type was created to hold human-readable text',
            self::CAA => 'CAA records allow domain owners to declare which certificate authorities are allowed to issue a certificate for a domain',
        };

        //return mb_convert_case($this->value, MB_CASE_UPPER, 'UTF-8');
    }

    public function valueMethodName(): string
    {
        return match ($this) {
            self::A => 'ip',
            self::AAAA => 'ipv6',
            self::CNAME, self::NS, self::MX, self::PTR, self::SRV => 'target',
            self::SOA => 'mname',
            self::TXT => 'txt',
            self::CAA => 'value',

        };
    }
}
