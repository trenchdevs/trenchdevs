<?php

namespace App\Modules\Users\Models;

use App\Modules\Emails\Models\EmailLog;
use App\Modules\Sites\Models\Site;
use App\Modules\Projects\Models\Project;
use App\Support\Traits\SiteScoped;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Throwable;

/**
 * Class User
 * @property array[] $certifications
 * @property array[] $degrees
 * @property array[] $experiences
 * @property ProjectUser $projects
 * @property array $skills
 * @property array $portfolioDetails
 * @property $email
 * @property $name
 * @property $first_name
 * @property $last_name
 * @property $id
 * @property $avatar_url
 * @property $external_id
 * @property $role
 * @property $site_id
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

    const ROLE_SUPER_ADMIN = 'superadmin';
    const ROLE_ADMIN = 'admin';
    const ROLE_BUSINESS_OWNER = 'business_owner';
    const ROLE_CUSTOMER = 'customer';
    const ROLE_CONTRIBUTOR = 'contributor';

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
        'first_name',
        'last_name',
        'email',
        'password',
        'is_active',
        'site_id',
        'avatar_url',
        'role',
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


    public function canManage(User $user)
    {
        return in_array($user->role, $this->getAllowedRolesToManage());
    }

    public function getAllowedRolesToManage(): array
    {

        // future: can be a levels map instead
        $rolesMap = [
            self::ROLE_SUPER_ADMIN => [
                self::ROLE_ADMIN,
                self::ROLE_BUSINESS_OWNER,
                self::ROLE_CUSTOMER,
                self::ROLE_CONTRIBUTOR,
            ],
            self::ROLE_ADMIN => [
                self::ROLE_BUSINESS_OWNER,
                self::ROLE_CUSTOMER,
                self::ROLE_CONTRIBUTOR,
            ],
            self::ROLE_CONTRIBUTOR => [
                self::ROLE_BUSINESS_OWNER,
                self::ROLE_CUSTOMER,
            ],
            self::ROLE_BUSINESS_OWNER => [
                self::ROLE_CUSTOMER,
            ],
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
        return "{$this->first_name} {$this->last_name}";
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
     * @param string $externalId
     * @return static|null
     */
    public static function findByUsername(string $externalId): ?self
    {
        /** @var User $user */
        $user = self::query()->where('external_id', $externalId)->first();
        return $user;
    }


    public function projects()
    {
        return $this->hasMany(Project::class);
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
     * @return Builder[]|Collection
     */
    public static function getBlogModerators()
    {
        return self::query()->whereIn('role', self::ADMIN_ROLES) // admin/superadmins are moderator for now
        ->where('is_active', 1)
            ->whereNotNull('email')
            ->whereNotNull('email_verified_at')
            ->get();
    }

    /**
     * @return array
     */
    public static function getBlogModeratorEmails(): array
    {
        $emails = [];
        $moderators = self::getBlogModerators();
        $moderatorsArr = $moderators->all();

        if (!empty($moderatorsArr)) {
            $emails = array_column($moderatorsArr, 'email');
        }

        return $emails;
    }

    public function lastLogin()
    {
        return $this->hasOne(UserLogin::class)->latest();
    }

    public function isIdle(int $inactiveMonths = 1)
    {

        if (!$this->lastLogin) {
            return true;
        }

        $lastLoginTimeStamp = $this->lastLogin->created_at;

        if (empty($lastLoginTimeStamp)) {
            return true;
        }

        $now = new DateTime();
        $lastLogin = DateTime::createFromFormat('Y-m-d H:s:i', $lastLoginTimeStamp);

        return (($now->diff($lastLogin)->m) >= $inactiveMonths);

    }

    /**
     * Check inactive users and sends deactivation notice email to inactive users
     *
     * @param int $inactiveMonths
     * @param string $userRole
     */
    public static function sendDeactivationNotice(int    $inactiveMonths = 1,
                                                  int    $noticeDays = 3,
                                                  string $userRole = self::ROLE_CONTRIBUTOR
    )
    {

        $users = self::where('is_active', 1)
            ->where('is_flagged_for_deactivation', 0)
            ->where('role', $userRole)
            ->get();

        foreach ($users as $user) {

            if ($user->isIdle($inactiveMonths)) {

                $user->is_flagged_for_deactivation = 1;
                $user->deactivation_notice_sent_at = date_now();
                $user->save();

                self::sendDeactivationEmail($user, $noticeDays);

            }

        }

    }

    /**
     * Sends deactivation notice email to inactive users
     *
     * @param User $user
     * @throws Throwable
     */
    public static function sendDeactivationEmail(User $user, int $noticeDays = 3)
    {

        $title = "Account subject to deactivation";
        $message = "Your account is subject to deactivation due to your inactivity in TrenchDevsAdmin. Please login within the next {$noticeDays} days to avoid this.";

        $viewData = [
            'name' => $user->name(),
            'email_body' => $message,
        ];

        EmailLog::queue(
            trim($user->email),
            $title,
            $viewData,
            'emails.generic'
        );

    }

    /**
     * Deactivates inactive users even after notice period
     *
     * @param int $noticeDays
     * @param string $userRole
     */
    public static function deactivateUsers(int $noticeDays = 3, string $userRole = self::ROLE_CONTRIBUTOR)
    {

        $latestLogins = DB::table('user_logins')
            ->selectRaw('user_id, MAX(created_at) AS last_login')
            ->groupBy('user_id');

        // Deactivate flagged users who DID NOT sign in within n days from deactivation notice
        DB::table('users')
            ->leftJoinSub($latestLogins, 'latest_logins', function ($join) {
                $join->on('users.id', '=', 'latest_logins.user_id');
            })
            ->where('users.is_active', 1)
            ->where('users.is_flagged_for_deactivation', 1)
            ->where('users.role', $userRole)
            ->whereRaw('TIMESTAMPDIFF(DAY, users.deactivation_notice_sent_at, NOW()) > ?', $noticeDays)
            ->where(function ($query) use ($noticeDays) {
                $query->whereRaw('TIMESTAMPDIFF(DAY, latest_logins.last_login, NOW()) > ?', $noticeDays)
                    ->orWhereNull('latest_logins.last_login');
            })
            ->update([
                'is_active' => 0,
                'is_flagged_for_deactivation' => 0,
                'deactivation_notice_sent_at' => null
            ]);

        // Set deactivation flag to 0 for users who signed in within n days from deactivation notice
        DB::table('users')
            ->joinSub($latestLogins, 'latest_logins', function ($join) {
                $join->on('users.id', '=', 'latest_logins.user_id');
            })
            ->where('users.is_active', 1)
            ->where('users.is_flagged_for_deactivation', 1)
            ->where('users.role', $userRole)
            ->whereRaw('TIMESTAMPDIFF(DAY, users.deactivation_notice_sent_at, NOW()) > ?', $noticeDays)
            ->whereRaw('TIMESTAMPDIFF(DAY, latest_logins.last_login, NOW()) <= ?', $noticeDays)
            ->update([
                'is_flagged_for_deactivation' => 0,
                'deactivation_notice_sent_at' => null
            ]);

    }

    ###########################################################################
    #                           Attributes
    ###########################################################################

    public function getNameAttribute(): string
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * Portfolio
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
    #                           Relationships
    ###########################################################################

    /**
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function getJsonAttributeValue(string $key): array
    {
        return UserJsonAttribute::getValueFromKey($this->id, $key, []);
    }


}
