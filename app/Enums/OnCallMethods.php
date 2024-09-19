<?php

namespace App\Enums;

use App\Concerns\EnumToArray;
use App\Models\Setting;

enum OnCallMethods: int
{
    use EnumToArray;

    case Call = 1;
    case Sms = 2;
    case Email = 3;
    case PushNotification = 4;
    case Discord = 5;
    case Slack = 6;
    case Teams = 7;

    public function text(): string
    {
        return match ($this) {
            self::Call => 'Call',
            self::Sms => 'Send SMS',
            self::Email => 'Send e-mail',
            self::PushNotification => 'Push Notification',
            self::Discord => 'Discord',
            self::Slack => 'Slack',
            self::Teams => 'Microsoft Teams',
        };
    }

    public static function actives(): array
    {
        /** @var Setting[] $channels */
        $channels = Setting::byGroup('channels');
        $data = [];

        foreach ($channels as $channel) {
            if (!empty($channel->value)) {
                $onCall = self::fromName($channel->key);

                $data[$onCall->value] = $onCall->text();
            }
        }

        return $data;
    }
}
