<?php

namespace App\Domains\Sites\Models;

use App\Domains\Sites\Models\Sites\SiteConfig;
use App\Providers\RouteServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Site
 * @package App\Models
 * @property $id
 * @property $domain
 * @property $identifier
 * @property $theme
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 */
class Site extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sites';

    protected $fillable = [
        'domain',
        'allow_wildcard_for_domain',
        'company_name',
        'identifier',
        'theme',
    ];

    const DB_IDENTIFIER_TRENCHDEVS = 'trenchdevs';
    const DB_IDENTIFIER_TRENCHAPPS = 'trenchapps';
    const DB_IDENTIFIER_CLOUDCRAFT = 'cloudcraft';


    /**
     * Alias to getInstance
     * @return static|null
     */
    public static function S(){
        return self::getInstance();
    }

    /** @var self */
    private static $singleton;

    public static function getInstance(): ?self {

        if (isset(self::$singleton) && !empty(self::$singleton)) {
            return self::$singleton;
        }

        $domain = get_domain();
        $strippedDomain = $domain;

        if (count($domainParts = explode('.', $domain)) > 2) {
            $strippedDomain = implode('.', array_slice($domainParts, -2, 2, false));
        }

        /** @var self singleton */
        self::$singleton = self::query()
            ->where(function (Builder $inner) use ($domain, $strippedDomain) {

                // it exactly match the domain
                $inner->where('domain', '=', $domain)
                    ->orWhere(function (Builder $inner) use ($strippedDomain) {
                        $inner->where('allow_wildcard_for_domain', 1)
                            ->where('domain', '=', "$strippedDomain");
                    });

            })
            ->first();

        return self::$singleton;
    }

    public static function getInstanceOrFail() {

        $instance = self::getInstance();

        if (!$instance) {
            abort(404, "Site not found");
        }

        return $instance;
    }

    /**
     * @param string $identifier
     *
     * @return static|null
     */
    public static function getByIdentifier(string $identifier): ?self {
        /** @var Site $site */
        $site = self::query()->where('identifier', $identifier)->first();
        return $site;
    }

    public function getConfigValueByKey(string $keyName): ?string {
        return SiteConfig::findByKeyName($this->id, $keyName)->key_value ?? null;
    }

    public function getRedirectPath(): ?string {

        $redirectPath = $this->getConfigValueByKey(SiteConfig::KEY_NAME_SYSTEM_LOGIN_REDIRECT_PATH);

        return !empty($redirectPath) ? $redirectPath : RouteServiceProvider::HOME;
    }

    /**
     * Whitelisted ips for a site
     *      used in conjunction with the IpRestricted middleware
     * @return array
     */
    public function getWhitelistedIps(): array {

        if (empty($whitelistedIps = json_decode_or_default($this->getConfigValueByKey(SiteConfig::KEY_NAME_SITE_WHITELISTED_IPS)))) {
            return [];
        }

        return $whitelistedIps;
    }

}
