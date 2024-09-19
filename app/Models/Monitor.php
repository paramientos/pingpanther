<?php

namespace App\Models;

use App\Dto\DomainRegistration\DomainDto;
use App\Dto\DomainRegistration\SSLDto;
use App\Dto\DomainRegistration\TLSDto;
use App\Enums\DnsTypes;
use App\Enums\DomainExpirationPeriods;
use App\Enums\FrequencyTypedChecks;
use App\Enums\MonitorFrequencyPeriods;
use App\Enums\MonitorType;
use App\Enums\OnCallMethods;
use App\Enums\SSLExpirationPeriods;
use App\Enums\Status\BecomesUnavailableStatus;
use App\Jobs\Monitors\BecomesUnavailable\DomainExpirationJob;
use App\Jobs\Monitors\BecomesUnavailable\SSLExpirationJob;
use App\Jobs\Monitors\BecomesUnavailable\TLSVerificationJob;
use App\Jobs\Monitors\DnsServer\DnsServerJob;
use App\Jobs\Monitors\ImapServer\ImapServerJob;
use App\Jobs\Monitors\Ping\PingJob;
use App\Jobs\Monitors\Pop3Server\Pop3ServerJob;
use App\Jobs\ObserverJobs\DeleteScreenShotsJob;
use App\Jobs\ObserverJobs\WhenDeletingMonitor;
use App\Services\DomainReg\DomainInfo;
use App\Services\DomainReg\SSLInfo;
use App\Services\DomainReg\TLSInfo;
use Carbon\CarbonInterval;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Monitor extends Model
{
    use HasUuids, Notifiable;

    protected $table = 'monitors';
    protected $guarded = [];


    protected $casts = [
        'monitor_type' => MonitorType::class,
        'first_alerted_at' => 'datetime',
        'first_seen_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'last_resolved_at' => 'datetime',
        'last_run_at' => 'datetime',
        'last_incident_at' => 'datetime',
        'screenshot_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleted(function (Monitor $monitor) {
            dispatch(new WhenDeletingMonitor($monitor->id));
            dispatch(new DeleteScreenShotsJob($monitor->id));
        });
    }

    public function getEndpointAttribute(string $endpoint)
    {
        try {
            $endpoint = decrypt($endpoint);
        } catch (DecryptException) {
            //
        }

        return $endpoint;
    }

    public function asyncRunMonitor(): void
    {
        dispatch($this->getMonitorJobInstance());
    }

    public function getMonitorJobInstance()
    {
        $type = $this->getMonitorType();

        $class = "\\App\\Jobs\\Monitors\\$type\\{$type}Job";

        if (class_exists($class)) {
            return new $class($this);
        }

        app('log')->error("{$class} job class not found in [asyncRunMonitor]!");
    }

    public function hasValidJobClass(): bool
    {
        $type = $this->getMonitorType();

        $class = "\\App\\Jobs\\Monitors\\$type\\{$type}Job";

        return class_exists($class);
    }

    public function getMonitorType(): string
    {
        $monitorType = $this->monitor_type;
        return $monitorType->getType();
    }

    public function parameter(string $param)
    {
        $array = json_decode($this->params, true) ?? [];

        return !empty($array[$param]) ? $array[$param] : null;
    }

    // General Params
    public function requestTimeout(): int
    {
        return $this->parameter('request_timeout');
    }

    // DnsServer ********************************************/
    public function dnsType(): DnsTypes
    {
        return DnsTypes::from($this->parameter('dns_type')) ?? DnsTypes::default();
    }

    public function expectedDnsValues(): ?array
    {
        return $this->parameter('expected_dns_values');
    }
    /*****************************************************/


    // Smtp Server ********************************************/
    public function smtpPort(): int
    {
        return (int)$this->parameter('smtp_port');
    }

    /*****************************************************/

    // Pop3 Server ********************************************/
    public function pop3Host(): string
    {
        return remove_http($this->endpoint);
    }

    public function pop3User(): string
    {
        return decrypt($this->parameter('pop3_user'));
    }

    public function pop3Password(): string
    {
        return decrypt($this->parameter('pop3_password'));
    }

    public function pop3Port(): int
    {
        return (int)$this->parameter('pop3_port');
    }

    public function pop3Ssl(): bool
    {
        return $this->parameter('pop3_ssl') === 'on';
    }

    public function pop3Tls(): bool
    {
        return $this->parameter('pop3_tls') === 'on';
    }

    /*****************************************************/

    // Imap Server ********************************************/
    public function imapHost(): string
    {
        return remove_http($this->endpoint);
    }

    public function imapUser(): string
    {
        return decrypt($this->parameter('imap_user'));
    }

    public function imapPassword(): string
    {
        return decrypt($this->parameter('imap_password'));
    }

    public function imapPort(): int
    {
        return (int)$this->parameter('imap_port');
    }

    public function imapSsl(): bool
    {
        return $this->parameter('imap_ssl') === 'on';
    }

    public function imapTls(): bool
    {
        return $this->parameter('imap_tls') === 'on';
    }

    /*****************************************************/

    public function paramsAsText(array $excludes = []): string
    {
        $array = json_decode($this->params, true) ?? [];

        foreach ($excludes as $key) {
            unset($array[$key]);
        }

        $text = '<ul>';

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $text .= Str::headline($key) . '<ul> ';

                foreach ($value as $item) {
                    $text .= sprintf('<li>%s</li>', $item);
                }

                $text .= '</ul>';
            } else {
                $text .= sprintf('<li>%s : %s</li>', Str::headline($key), $value);
            }
        }

        $text .= '</ul>';

        return $text;
    }

    public function suitableToRun(bool $force = false): bool
    {
        if ($force) {
            return true;
        }

        $seconds = date('s');

        if ($seconds === '30') {
            if (MonitorFrequencyPeriods::isInSeconds($this->check_frequency_period)) {
                $timeCriteria = $seconds;
                $period = $this->check_frequency_period;

                return $timeCriteria % $period === 0;
            }

            return false;
        }

        if (MonitorFrequencyPeriods::isInMinutes($this->check_frequency_period)) {
            $timeCriteria = date('i');
            $period = $this->freqPeriodInMinute();

            //info(sprintf('%s,%s,%s-> %s', $this->endpoint, $timeCriteria, $period,($timeCriteria % $period === 0)));

            return $timeCriteria % $period === 0;
        }

        return false;
    }

    public function freqPeriodInMinute(): float|int
    {
        return ($this->check_frequency_period / 60);
    }

    public function freqPeriodAsText(): string
    {
        $period = $this->freqPeriodInMinute();
        $type = 'minutes';

        $period === 1 && $type = 'minute';

        if ($period < 1) {
            $type = 'seconds';
            $period *= 60;
        }

        return sprintf('%s %s', $period, $type);
    }

    public function hasOnCallMethods(): bool
    {
        return !is_null($this->on_call_methods);
    }

    public function isMaintenanceSlot(): bool
    {
        if (!$this->maintenance_start_time || !$this->maintenance_finish_time) {
            return false;
        }

        $startDate = Carbon::createFromFormat('H:i:s', $this->maintenance_start_time);
        $endDate = Carbon::createFromFormat('H:i:s', $this->maintenance_finish_time);

        $startDate->shiftTimezone($this->timezone);
        $endDate->shiftTimezone($this->timezone);

        return now()->timezone($this->timezone)->between($startDate, $endDate, true);
    }

    /* SSL ******************************************************************************/
    public function willCheckSSLExpire(): bool
    {
        return $this->ssl_expiration_period !== SSLExpirationPeriods::DONT_CHECK->value;
    }

    public function sslInfo(): ?SSLDto
    {
        return (new SSLInfo($this->endpoint))->info();
    }

    public function runSSLExpirationJob()
    {
        dispatch(new SSLExpirationJob($this));
    }

    public function willCheckTLSVerification(): bool
    {
        return $this->verify_ssl === true;
    }

    public function tlsInfo(): ?TLSDto
    {
        return (new TLSInfo($this->endpoint))->info();
    }

    public function runTLSVerificationJob()
    {
        dispatch(new TLSVerificationJob($this));
    }
    /************************************************************************************/


    /* Domain Info **********************************************************************/
    public function domainInfo(): ?DomainDto
    {
        return (new DomainInfo($this->endpoint))->get();
    }

    public function willDomainExpire(): bool
    {
        return (new DomainInfo($this->endpoint))->isExpired($this->domain_expiration_period);
    }

    public function willCheckDomainExpire(): bool
    {
        return $this->domain_expiration_period !== DomainExpirationPeriods::DONT_CHECK->value;
    }

    public function runDomainExpirationJob()
    {
        dispatch(new DomainExpirationJob($this));
    }

    public function runPingableJob()
    {
        dispatch(new PingJob($this));
    }

    public function runDnsServerJob()
    {
        dispatch(new DnsServerJob($this));
    }

    public function runPop3ServerJob()
    {
        dispatch(new Pop3ServerJob($this));
    }

    public function runImapServerJob()
    {
        dispatch(new ImapServerJob($this));
    }

    public function isDomain(): bool
    {
        return !pp_is_ip($this->endpoint);
    }

    public function isIP(): bool
    {
        return pp_is_ip($this->endpoint);
    }

    public function screenshotPath(bool $versioned = false): ?string
    {
        $image = sprintf('/ss/%s.png', md5($this->id));
        $path = public_path($image);

        if (file_exists($path)) {
            return sprintf('%s%s', $image, ($versioned ? '?v=' . uniqid() : ''));
        }

        return null;
    }

    public function screenshotAsset(): ?string
    {
        if ($this->screenshotPath()) {
            return asset($this->screenshotPath(versioned: true));
        }

        return null;
    }

    public function screenshot(): string
    {
        $image = $this->screenshotAsset();

        if (!$image) {
            return asset('assets/no-image.png');
        }

        return $image;
    }

    public function screenshotText(): string
    {
        if (is_null($this->screenshot_at)) {
            return '';
        }

        return sprintf('Taken at %s',
            $this->screenshot_at
                ->timezone(logged_user_timezone())
                ->format('l jS \o\f F Y H:i:s')
        );
    }

    /***********************************************************************************/

    public function isFine(): bool
    {
        $lastAlertLog = AlertLog::where('check_id', $this->id)->latest()->first();

        if (!$lastAlertLog) {
            return false;
        }

        return get_event_status($lastAlertLog->check->monitor_type, $lastAlertLog->event, excludes: [BecomesUnavailableStatus::DOMAIN_WILL_EXPIRE->value]) === true;
    }

    public function isNotFine(): bool
    {
        return !$this->isFine();
    }

    public function uptime(): ?string
    {
        if (!$this->first_seen_at || !$this->last_seen_at) {
            return null;
        }

        $lastSeen = $this->last_seen_at;

        $this->isFine() && $lastSeen = now();

        $lengthInSeconds = Carbon::parse($this->first_seen_at)->diffInSeconds($lastSeen);

        return CarbonInterval::seconds($lengthInSeconds)->cascade()->forHumans();
    }

    // Relations
    public function activities(): HasMany
    {
        return $this->hasMany(ActivityLog::class, 'check_id', 'id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(AlertLog::class, 'check_id', 'id');
    }

    public function lastLog(): HasOne
    {
        return $this->hasOne(AlertLog::class, 'check_id', 'id')->latest();
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class, 'check_id', 'id');
    }

    public function scopeActives(Builder $builder): Builder
    {
        return $builder->where('status', true);
    }

    // Customs
    public function clearFrequencyValues()
    {
        $this->update([
            'first_alerted_at' => null,
            'alert_count' => 0
        ]);
    }

    public function channelsAsText(): string
    {
        return implode(',', $this->getChannels());
    }

    public function getChannels(): array
    {
        $channels = json_decode($this->on_call_methods, true) ?? [];
        return collect($channels)->map(fn($channelId) => OnCallMethods::from((int)$channelId)->name)->toArray();
    }

    public function isSuitableToAlertAgain(int $frequencyTypeInSeconds): bool
    {
        return now()->diffInSeconds($this->first_alerted_at) >= $frequencyTypeInSeconds;
    }

    public function isFrequencyTyped(): bool
    {
        return in_array($this->monitor_type, FrequencyTypedChecks::values());
    }

    public function routeNotificationForWebhook(): ?string
    {
        if ($this->parameter('web_hook')) {
            return $this->parameter('web_hook');
        }

        $params = json_decode($this->attributes['attributes']);
        return $params?->webhook_url;
    }

    public function routeNotificationForSlack(): mixed
    {
        if ($this->parameter('slack_hook')) {
            return $this->parameter('slack_hook');
        }

        return Setting::byKey('channels', 'Slack');
    }

    public function routeNotificationForDiscord(): string
    {
        if ($this->parameter('discord_hook')) {
            return $this->parameter('discord_hook');
        }

        return Setting::byKey('channels', 'Discord');
    }

    public function routeNotificationForTeams()
    {
        if ($this->parameter('teams_hook')) {
            return $this->parameter('teams_hook');
        }

        return Setting::byKey('channels', 'Teams');
    }
}
