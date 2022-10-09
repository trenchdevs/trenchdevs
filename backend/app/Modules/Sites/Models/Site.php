<?php

namespace App\Modules\Sites\Models;

use App\Modules\Sites\Enums\SiteIdentifier;
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
 * @property $inertia_theme
 *
 * @property Collection $configs
 */
class Site extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sites';

    protected $appends = [
        'configs'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'domain',
        'allow_wildcard_for_domain',
        'company_name',
        'identifier',
        'theme',
        'inertia_theme',
    ];

    /**
     * @param SiteIdentifier $identifier
     * @return Site|null
     */
    public static function fromIdentifier(SiteIdentifier $identifier): ?static
    {
        /** @var Site $site */
        $site = self::query()->where('identifier', '=', $identifier->value)->first();
        return $site;
    }

    public static function setInstance(Site $site)
    {
        self::$singleton = $site;
    }

    /**
     * @var static
     */
    private static Site $singleton;

    /**
     * @return static|null
     */
    public static function getInstance(): ?static
    {
        try {

            return app(Site::class);

        } catch (Throwable $throwable) {
            // ignore on production - 404
            if (app()->environment('local', 'testing') && !app()->runningInConsole()) {
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
    public static function findByIdentifier(string $identifier): ?self
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
    public function config(string $keyName, string $defaultValue = null): ?string
    {

        if (!$this->id) {
            return $defaultValue;
        }

        return $this->configs->get($keyName, $defaultValue) ?? $defaultValue;
    }

    /**
     * @param $keyName
     * @param $keyValue
     * @param string $comments
     * @return Model|Builder
     */
    public function setConfig($keyName, $keyValue, string $comments): Model|Builder
    {
        return SiteConfig::query()->updateOrCreate(
            ['key_name' => $keyName,'site_id' => $this->id],
            ['key_value'=> $keyValue, 'comments' => $comments]
        );
    }

    /**
     * @return mixed
     */
    public function getConfigsAttribute(): mixed
    {
        return SiteConfig::query()->where('site_id', '=', $this->id)
            ->get()
            ->keyBy('key_name')
            ->map(fn($obj) => $obj->key_value);
    }

    /**
     * @param string $configKey
     * @param string $jsonKey
     * @param string $default
     * @return string
     */
    public function configJson(string $configKey, string $jsonKey, string $default): string
    {
        $json = $this->config($configKey, $default);

        if (!is_json($json)) {
            return $default;
        }

        $jsonArray = json_decode_or_default($json);

        return Arr::get($jsonArray, $jsonKey, $default);
    }

    public function json(string $key, $default = [])
    {
        $value = DB::table('site_jsons')->where('site_id', '=', $this->id)
            ->where('key', '=', $key)
            ->first()
            ->value ?? null;

        if (empty($value)) {
            return $default;
        }

        return json_decode_or_default($value);
    }

    /**
     * @return Collection
     */
    public function getFaqs(): Collection
    {
        return collect($this->json('content::faqs', []));
    }

    public function getRedirectPath(): ?string
    {

        $redirectPath = $this->config(SiteConfig::KEY_NAME_SYSTEM_LOGIN_REDIRECT_PATH);

        return !empty($redirectPath) ? $redirectPath : RouteServiceProvider::HOME;
    }

    /**
     * Whitelisted ips for a site
     *      used in conjunction with the IpRestricted middleware
     * @return array
     */
    public function getWhitelistedIps(): array
    {

        if (empty($whitelistedIps = json_decode_or_default($this->config(SiteConfig::KEY_NAME_SITE_WHITELISTED_IPS)))) {
            return [];
        }

        return $whitelistedIps;
    }

    public function http(string $path): string
    {
        return "http://$this->domain$path";
    }

    public function https(string $path): string
    {
        return "https://$this->domain$path";
    }

}
