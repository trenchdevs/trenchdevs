<?php

namespace App\Models\Users;

use App\Helpers\UrlHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPortfolioDetail
 * @property $portfolio_view
 * @package App\Models\Users
 */
class UserPortfolioDetail extends Model
{
    protected $table = 'user_portfolio_details';

    protected $fillable = [
        'tagline',
        'user_id',
        'background_cover_url',
        'primary_phone',
        'github_url',
        'linkedin_url',
        'resume_url',
        'interests',
    ];

    const FIELDS_WITH_NO_SCHEME = [
        'github_url',
        'linkedin_url',
        'resume_url'
    ];

    // can be on DB later on
    const VALID_VIEWS = [
        // view => label
        'portfolio.show' => 'Default',
        'portfolio.custom.basic' => 'Basic (StartBootstrap Template)',
    ];

    public static function findOrEmptyByUser(int $userId): self
    {

        $detail = self::where('user_id', $userId)
            ->first();

        if (empty($detail)) {
            $detail = new self;
        }

        return $detail;
    }

    /**
     * @param array $requestArr
     * @return array
     */
    public static function sanitizeFields(array &$requestArr)
    {

        $urlHelper = new UrlHelper();
        /**
         * remove schemes on url when storing on db
         */
        foreach (self::FIELDS_WITH_NO_SCHEME as $field) {
            $reqValue = $requestArr[$field] ?? null;
            if (!empty($reqValue)) {
                $requestArr[$field] = $urlHelper->removeScheme($reqValue);
            }
        }

        return $requestArr;
    }
}
