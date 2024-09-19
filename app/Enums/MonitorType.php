<?php

namespace App\Enums;

use App\Concerns\EnumToArray;
use Illuminate\Support\Str;

enum MonitorType: int
{
    use EnumToArray;

    case BECOMES_UNAVAILABLE = 1;
    case HTTP_STATUS = 2;
    case PING = 3;
    case PING_TCP = 4;
    case PING_UDP = 5;
    case SMTP_SERVER = 6;
    case POP3_SERVER = 7;
    case IMAP_SERVER = 8;
    case DNS_SERVER = 9;

    public function getType(): string
    {
        return Str::studly(Str::title($this->name));
    }

    public function text(): string
    {
        return match ($this) {
            self::BECOMES_UNAVAILABLE => 'Becomes Unavailable',
            self::HTTP_STATUS => 'Returns HTTP status other than',
            self::PING => "Doesn't respond to ping",
            self::PING_TCP => "Doesn't respond at a TCP port",
            self::PING_UDP => "Doesn't respond at a UDP port",
            self::SMTP_SERVER => "SMTP server doesn't respond",
            self::POP3_SERVER => "POP3 server doesn't respond",
            self::IMAP_SERVER => "IMAP server doesn't respond",
            self::DNS_SERVER => "DNS server values changed",
        };
    }

    public function placeholder(): string
    {
        return match ($this) {
            self::BECOMES_UNAVAILABLE => '',
            self::HTTP_STATUS => '',
            self::PING => "",
            self::PING_TCP => "",
            self::PING_UDP => "",
            self::SMTP_SERVER => "for example: smtp.gmail.com",
            self::POP3_SERVER => "",
            self::IMAP_SERVER => "",
            self::DNS_SERVER => "",
        };
    }

    public function endpointType(bool $uppercaseFirst = false, bool $returnEmpty = false): string
    {
        if ($returnEmpty) {
            return '';
        }

        $text = match ($this) {
            self::BECOMES_UNAVAILABLE, self::HTTP_STATUS => 'URL',
            self::PING, self::PING_UDP, self::PING_TCP, self::POP3_SERVER, self::IMAP_SERVER => 'host',
            self::DNS_SERVER, self::SMTP_SERVER => 'domain address'
        };

        return $uppercaseFirst
            ? ucfirst($text)
            : $text;
    }

    public static function byOrder(): array
    {
        return [
            self::BECOMES_UNAVAILABLE,
            self::HTTP_STATUS,
            self::PING,
            self::PING_TCP,
            self::PING_UDP,
            self::SMTP_SERVER,
            self::POP3_SERVER,
            self::IMAP_SERVER,
            self::DNS_SERVER,
        ];
    }

    public function isBecomesUnavailable(): bool
    {
        return $this === self::BECOMES_UNAVAILABLE;
    }

    public function isInPingGroup(): bool
    {
        return in_array($this, [
            self::PING,
            self::PING_TCP,
            self::PING_UDP,
        ]);
    }

    public static function pingGroup(): array
    {
        return [
            self::PING->value,
            self::PING_TCP->value,
            self::PING_UDP->value,
        ];
    }

    public function hasResponseTime(): bool
    {
        return in_array($this, [
            self::BECOMES_UNAVAILABLE,
            self::HTTP_STATUS,
        ]);
    }

    public function hasDomainRelated(): bool
    {
        return in_array($this, [
            self::BECOMES_UNAVAILABLE,
            self::HTTP_STATUS,
        ]);
    }

    public function hasPingRelated(): bool
    {
        return in_array($this, [
            self::PING,
            self::PING_TCP,
            self::PING_UDP,
        ]);
    }

    public function isDnsServer(): bool
    {
        return $this == self::DNS_SERVER;
    }

    public function isSmtpServer(): bool
    {
        return $this == self::SMTP_SERVER;
    }

    public function isPop3Server(): bool
    {
        return $this == self::POP3_SERVER;
    }

    public function isImapServer(): bool
    {
        return $this == self::IMAP_SERVER;
    }

    public function shouldEncrypt(): bool
    {
        return in_array($this, [self::POP3_SERVER, self::IMAP_SERVER]);
    }

    public static function mailReceiverGroup(): array
    {
        return [
            self::POP3_SERVER->value,
            self::IMAP_SERVER->value,
        ];
    }

    public function shouldReturnEmptyString(): bool
    {
        return in_array($this, [
            self::DNS_SERVER,
            self::IMAP_SERVER,
            self::POP3_SERVER,
            self::SMTP_SERVER,
        ]);
    }

    public function helpText(): string
    {
        return match ($this) {
            self::BECOMES_UNAVAILABLE => 'Becomes unavailable triggers an incident when the response status code is outside the 2XX range after redirects',
            self::HTTP_STATUS => 'Create log/alert when the endpoint status code different from the expected status code(s) below',
            self::PING => '',
            self::PING_TCP => '',
            self::PING_UDP => '',
            self::SMTP_SERVER => "Checks if SMTP server can send mail",
            self::POP3_SERVER => '',
            self::IMAP_SERVER => '',
            self::DNS_SERVER => '',
        };
    }

    public function endpointFormType(): string
    {
        return match ($this) {
            self::BECOMES_UNAVAILABLE => 'url',
            self::HTTP_STATUS => 'url',
            self::PING => 'ip',
            self::PING_TCP => 'ip',
            self::PING_UDP => 'ip',
            self::SMTP_SERVER => 'text',
            self::POP3_SERVER => 'url',
            self::IMAP_SERVER => 'url',
            self::DNS_SERVER => 'url',
        };
    }
}
