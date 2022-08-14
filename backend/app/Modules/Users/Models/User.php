<?php

namespace App\Modules\Users\Models;

use App\Modules\Projects\Models\Project;
use App\Modules\Sites\Models\Site;
use App\Modules\Sites\Traits\SiteScoped;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Throwable;

/**
 * Class User
 * @property $id
 * @property $is_active
 * @property $email
 * @property $name
 * @property $first_name
 * @property $last_name
 * @property $avatar_url
 * @property $external_id
 * @property $role
 * @property $site_id
 *
 * @property array[] $certifications
 * @property array[] $degrees
 * @property array[] $experiences
 * @property array $skills
 *
 * @property array $portfolioDetails
 * @property ProjectUser $projects
 * @property UserLogin $latestLogin
 * @property Site $site
 * @package App
 */
class User extends Authenticatable // implements MustVerifyEmail
{
    use Notifiable;
    use HasApiTokens;
    use SiteScoped;
    use SoftDeletes;
    use HasFactory;

    /**
     * Webmaster(s)
     */
    const ROLE_SUPER_ADMIN = 'superadmin';

    /**
     * Moderators/Admin
     */
    const ROLE_ADMIN = 'admin';

    /**
     * Support/Contributor/Admin Assitant
     */
    const ROLE_CONTRIBUTOR = 'contributor';

    /**
     * Business/Site Owner
     */
    const ROLE_BUSINESS_OWNER = 'business_owner';

    /**
     * Customer/End-Users
     */
    const ROLE_CUSTOMER = 'customer';

    const ADMIN_ROLES = [
        self::ROLE_SUPER_ADMIN,
        self::ROLE_ADMIN,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_id',
        'is_active',
        'email',
        'external_id',
        'role',
        'first_name',
        'last_name',
        'password',
        'email_verified_at',
        'avatar_url',
        'deleted_at',
    ];

    protected $appends = [
        'name', // getNameAttribute
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    ###########################################################################
    #                           Relationships
    ###########################################################################

    /**
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }


    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }


    public function latestLogin(): HasOne
    {
        return $this->hasOne(UserLogin::class)->latest();
    }



    ###########################################################################
    #                           Attributes
    ###########################################################################

    public function getNameAttribute(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     *
     * Portfolio
     *
     */

    public function getSkillsAttribute(): array
    {
        return $this->getJsonAttributeValue('system::portfolio::skills');
    }

    public function getExperiencesAttribute(): array
    {
        return $this->getJsonAttributeValue('system::portfolio::experiences');
    }

    public function getCertificationsAttribute(): array
    {
        return $this->getJsonAttributeValue('system::portfolio::certifications');
    }

    public function getDegreesAttribute(): array
    {
        return $this->getJsonAttributeValue('system::portfolio::degrees');
    }

    public function getPortfolioDetailsAttribute(): array
    {
        return $this->getJsonAttributeValue('system::portfolio::details');
    }




    ###########################################################################
    #                           Static Methods
    ###########################################################################
    /**
     * @param string $externalId
     * @return static|null
     */
    public static function findByUsername(string $externalId): ?self
    {
        /** @var User $user */
        $user = self::query()->where('external_id', $externalId)->first();
        return $user;
    }

    /**
     * @return Builder[]|Collection
     */
    public static function getBlogModerators(): Collection|array
    {
        return self::query()->whereIn('role', self::ADMIN_ROLES) // admin/superadmins are moderator for now
        ->where('is_active', 1)
            ->whereNotNull('email')
            ->whereNotNull('email_verified_at')
            ->get();
    }


    ###########################################################################
    #                           Reg Methods
    ###########################################################################


    public function canManage(User $user): bool
    {
        return in_array($user->role, $this->getAllowedRolesToManage());
    }

    /**
     * future: can be a levels map instead
     * @return array
     */
    public function getAllowedRolesToManage(): array
    {
        $rolesMap = [
            self::ROLE_SUPER_ADMIN => [self::ROLE_ADMIN,self::ROLE_BUSINESS_OWNER, self::ROLE_CUSTOMER,self::ROLE_CONTRIBUTOR],
            self::ROLE_ADMIN => [self::ROLE_BUSINESS_OWNER,self::ROLE_CUSTOMER,self::ROLE_CONTRIBUTOR],
            self::ROLE_CONTRIBUTOR => [self::ROLE_BUSINESS_OWNER,self::ROLE_CUSTOMER],
            self::ROLE_BUSINESS_OWNER => [self::ROLE_CUSTOMER],
            self::ROLE_CUSTOMER => [],
        ];

        return $rolesMap[$this->role] ?? [];
    }

    /**
     * User is active
     * @return bool
     */
    public function isActive(): bool
    {
        return intval($this->is_active) == 1;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return "$this->first_name $this->last_name";
    }

    /**
     * @throws Throwable
     */
    public function activateOrFail(): void
    {
        if (!$this->isActive()) {
            $this->is_active = 1;
            $this->saveOrFail();
        }
    }

    /**
     * @return array
     */
    public function getPortfolioDetails(): array
    {
        return $this->portfolioDetails;
    }

    /**
     * @return string
     */
    public function getPortfolioUrl(): string
    {

        $portfolioUrl = '';

        if (!empty($this->external_id)) {
            $portfolioUrl = get_portfolio_url($this->external_id);
        }

        return $portfolioUrl;
    }

    /**
     * @return bool
     */
    public function canAnnounce(): bool
    {
        return in_array($this->role, self::ADMIN_ROLES);
    }

    /**
     * @return bool
     */
    public function hasAccessToBlogs(): bool
    {
        return in_array($this->role, array_merge(
            self::ADMIN_ROLES,
            [self::ROLE_CONTRIBUTOR]
        ));
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return in_array($this->role, self::ADMIN_ROLES);
    }

    /**
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isBlogModerator(): bool
    {
        return $this->isAdmin();
    }

    /**
     * @param string $key
     * @return array
     */
    public function getJsonAttributeValue(string $key): array
    {
        return UserJsonAttribute::getValueFromKey($this->id, $key, []);
    }


}
