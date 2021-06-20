<?php

namespace App\Models;

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
 */
class Site extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sites';

    protected $fillable = [
        'domain',
        'company_name',
        'identifier'
    ];

    const DB_IDENTIFIER_TRENCHDEVS = 'trenchdevs';


    /** @var self */
    private static $singleton;

    public static function getInstance(): ?self
    {

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

    public static function getInstanceOrFail()
    {

        $instance = self::getInstance();

        if (!$instance) {
            abort(404, "Site not found");
        }

        return $instance;
    }

    /**
     * @param string $identifier
     * @return static|null
     */
    public static function getByIdentifier(string $identifier): ?self{
        /** @var Site $site */
        $site = self::query()->where('identifier', $identifier)->first();
        return $site;
    }

}
