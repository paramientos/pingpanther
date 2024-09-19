<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Domain
 *
 * @property string $id
 * @property string $monitor_id
 * @property string $domain_name
 * @property bool|null $notified
 * @property string $whois_server
 * @property string|null $name_servers
 * @property string|null $owner
 * @property string|null $registrar
 * @property string|null $dnssec
 * @property string $creation_date
 * @property string $expiration_date
 * @property string|null $updated_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereCreationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereDnssec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereDomainName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereExpirationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereMonitorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereNameServers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereOwner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereRegistrar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereUpdatedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Domain whereWhoisServer($value)
 * @mixin \Eloquent
 */
class Domain extends Model
{
    use HasUuids;

    protected $table = 'domains';
    protected $guarded = [];

    public function hasNotified(): bool
    {
        return $this->notified;
    }

    public function hasNotNotified(): bool
    {
        return empty($this->notified);

    }
}
