<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SslCertificate
 *
 * @property string $id
 * @property string $monitor_id
 * @property string $domain_name
 * @property string $issuer_name
 * @property bool|null $notified
 * @property string|null $valid_from
 * @property string|null $valid_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate query()
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereDomainName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereIssuerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereMonitorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereNotified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereValidFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereValidTo($value)
 * @property bool|null $is_tls_valid
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereIsTlsValid($value)
 * @property string|null $tls_info
 * @method static \Illuminate\Database\Eloquent\Builder|SslCertificate whereTlsInfo($value)
 * @mixin \Eloquent
 */
class SslCertificate extends Model
{
    use HasUuids;

    protected $table = 'ssl_certificates';
    protected $guarded = [];


    public function hasNotNotified(): bool
    {
        return empty($this->notified);

    }
}
