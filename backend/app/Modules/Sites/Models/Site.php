<?php

namespace App\Modules\Sites\Models;

use App\Modules\Sites\Models\Sites\SiteConfig;
use App\Modules\Sites\Models\Sites\SiteFactory;
use App\Providers\RouteServiceProvider;
use ArrayAccess;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

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
    const DB_IDENTIFIER_DEMO = 'demo';
    const DB_IDENTIFIER_CLOUDCRAFT = 'cloudcraft';


    /**
     * @param string $identifier
     * @return Site|null
     */
    public static function fromIdentifier(string $identifier): ?static
    {
        /** @var Site $site */
        $site = self::query()->where('identifier', '=', $identifier)->first();
        return $site;
    }

    /**
     * Alias to getInstance
     * @return static|null
     */
    public static function S()
    {
        return self::getInstance();
    }

    public static function setSiteInstance(Site $site)
    {
        self::$singleton = $site;
    }

    /**
     * @var static
     */
    private static $singleton;

    /**
     * @return static|null
     */
    public static function getInstance(): ?static
    {
        try {

            if (isset(self::$singleton) && !empty(self::$singleton)) {
                return self::$singleton;
            }
            return SiteFactory::getInstanceOrNull();

        } catch (Throwable $throwable) {
            // ignore on production - 404
            if (app()->environment('local') && !app()->runningInConsole()) {
                dd($throwable->getMessage());
            }
        }

        return self::$singleton;
    }

    /**
     * @param string $identifier
     *
     * @return static|null
     */
    public static function getByIdentifier(string $identifier): ?self
    {
        /** @var Site $site */
        $site = self::query()->where('identifier', $identifier)->first();
        return $site;
    }

    /**
     * @param string $keyName
     * @param string|null $defaultValue
     * @return string|null
     */
    public function getConfigValueByKey(string $keyName, string $defaultValue = null): ?string
    {

        if (!$this->id) {
            return $defaultValue;
        }

        if (!isset($this->config)) {
            $this->config = SiteConfig::query()->where('site_id', '=', $this->id)->get()->keyBy('key_name');
        }

        return $this->config->get($keyName, $defaultValue)->key_value ?? $defaultValue;
    }

    /**
     * @param string $configKey
     * @param string $jsonKey
     * @param string $default
     * @return string
     */
    public function getConfigValueFromJson(string $configKey, string $jsonKey, string $default): string
    {
        $json = $this->getConfigValueByKey($configKey, $default);

        if (!td_is_json($json)) {
            return $default;
        }

        $jsonArray = td_json_decode_or_default($json);

        return Arr::get($jsonArray, $jsonKey, $default);
    }

    public function getSiteJson(string $key, $default = [])
    {
        $value = DB::table('site_jsons')->where('site_id', '=', $this->id)
                ->where('key', '=', $key)
                ->first()
                ->value ?? null;

        if (empty($value)) {
            return $default;
        }

        return td_json_decode_or_default($value);
    }

    /**
     * @return Collection
     */
    public function getFaqs(): Collection
    {
        return collect($this->getSiteJson('content::faqs', []));
    }

    /**
     * @param $key
     * @param $jsonKey
     * @param $default
     * @return array|ArrayAccess|mixed
     */
    public function getSiteJsonValueFromKey($key, $jsonKey, $default): mixed
    {
        return Arr::get($this->getSiteJson($key, $default), $jsonKey, []);
    }

    public function getRedirectPath(): ?string
    {

        $redirectPath = $this->getConfigValueByKey(SiteConfig::KEY_NAME_SYSTEM_LOGIN_REDIRECT_PATH);

        return !empty($redirectPath) ? $redirectPath : RouteServiceProvider::HOME;
    }

    /**
     * Whitelisted ips for a site
     *      used in conjunction with the IpRestricted middleware
     * @return array
     */
    public function getWhitelistedIps(): array
    {

        if (empty($whitelistedIps = td_json_decode_or_default($this->getConfigValueByKey(SiteConfig::KEY_NAME_SITE_WHITELISTED_IPS)))) {
            return [];
        }

        return $whitelistedIps;
    }

}
