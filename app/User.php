<?php

namespace App;

use App\Models\EmailQueue;
use App\Models\Users\UserCertification;
use App\Models\Users\UserDegree;
use App\Models\Users\UserExperience;
use App\Models\Users\UserPortfolioDetail;
use App\Models\Projects\Project;
use App\Models\Users\UserSkill;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Throwable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @property UserCertification[] $certifications
 * @property UserDegree[] $degrees
 * @property UserExperience[] $experiences
 * @property UserProject $projects
 * @property UserSkill $skills
 * @property $email
 * @property $id
 * @property $avatar_url
 * @property $username
 * @property $role
 * @package App
 */
class User extends Authenticatable implements JWTSubject, MustVerifyEmail
{
    use Notifiable;

    const ROLE_SUPER_ADMIN = 'superadmin';
    const ROLE_ADMIN = 'admin';
    const ROLE_BUSINESS_OWNER = 'business_owner';
    const ROLE_CUSTOMER = 'customer';
    const ROLE_CONTRIBUTOR = 'contributor';

    const VALID_ROLES = [
        self::ROLE_SUPER_ADMIN,
        self::ROLE_ADMIN,
        self::ROLE_BUSINESS_OWNER,
        self::ROLE_CUSTOMER,
        self::ROLE_CONTRIBUTOR,
    ];

    const ADMIN_ROLES = [
        self::ROLE_SUPER_ADMIN,
        self::ROLE_ADMIN,
    ];

    const SHOP_ADMIN_ROLES = [
        self::ROLE_SUPER_ADMIN,
        self::ROLE_ADMIN,
        self::ROLE_BUSINESS_OWNER,
    ];

    private $portfolioUrl;

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
        'account_id',
        'role',
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

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
     * @return User[]
     */
    public static function getTrenchDevsUsers()
    {

        return self::where('account_id', 1)
            ->get();
    }

    /**
     * @return UserPortfolioDetail
     */
    public function getPortfolioDetails(): UserPortfolioDetail
    {
        return UserPortfolioDetail::findOrEmptyByUser($this->id);
    }


    /**
     * @param $username
     * @return static|null
     */
    public static function findByUsername(string $username): ?self
    {
        return self::where('username', $username)
            ->first();
    }

    /**
     * @param string $username
     * @return $this
     */
    public static function findByUserNameOrFail(string $username): self
    {
        $user = self::findByUsername($username);

        if (empty($user)) {
            throw new \InvalidArgumentException("Username not found");
        }

        return $user;
    }

    public function certifications()
    {
        return $this->hasMany(UserCertification::class);
    }

    public function experiences()
    {
        return $this->hasMany(UserExperience::class);
    }

    public function degrees()
    {
        return $this->hasMany(UserDegree::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function skills()
    {
        return $this->hasOne(UserSkill::class);
    }

    public function portfolioDetails()
    {
        return $this->hasOne(UserPortfolioDetail::class);
    }


    /**
     * @return string
     */
    public function getPortfolioUrl(): string
    {

        $portfolioUrl = '';

        if (!empty($this->username)) {
            $portfolioUrl = get_portfolio_url($this->username);
        }

        // cache on instance
        if (!isset($this->portfolioUrl)) {
            $this->portfolioUrl = $portfolioUrl;
        }

        return $this->portfolioUrl;
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

    public function canManageShop(): bool
    {
        return in_array($this->role, self::SHOP_ADMIN_ROLES);
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

    /**
     * @param int $inactiveMonths
     */
    public static function deactivateUsers(int $inactiveMonths = 1, int $noticeDays = 3)
    {

        self::sendDeactivationNotice($inactiveMonths);
        self::processUsersForDeactivation($noticeDays);

    }

    public static function sendDeactivationNotice(int $inactiveMonths = 1, string $userRole = self::ROLE_CONTRIBUTOR)
    {

        $latestLogins = DB::table('user_logins')
            ->selectRaw('user_id, MAX(created_at) AS last_login')
            ->groupBy('user_id');

        $usersFlaggedForDeactivation = DB::table('users')
            ->joinSub($latestLogins, 'latest_logins', function ($join) {
                $join->on('users.id', '=', 'latest_logins.user_id');
            })
            ->where('users.is_active', 1)
            ->where('users.is_flagged_for_deactivation', 0)
            ->where('users.role', '=', $userRole)
            ->whereRaw('TIMESTAMPDIFF(MONTH, latest_logins.last_login, NOW()) >= ?', $inactiveMonths)
            ->update(['is_flagged_for_deactivation' => 1]);

        // sending of mails
        self::sendDeactivationEmail($usersFlaggedForDeactivation);

    }

    public static function sendDeactivationEmail($users)
    {

        $title = "Account subject to deactivation";
        $message = "Your account is subject to deactivation due to your idle time in Trenchdevs. Please login within the next 3 days to avoid this.";

        foreach ($users as $user) {

            $userName = "{$user->first_name} {$user->last_name}";

            $viewData = [
                'name' => $userName,
                'email_body' => $message,
            ];

            EmailQueue::queue(
                trim($user->email),
                $title,
                $viewData,
                'emails.generic'
            );

        }

    }

    public static function processUsersForDeactivation(int $noticeDays = 3, string $userRole = self::ROLE_CONTRIBUTOR)
    {

        $latestLogins = DB::table('user_logins')
            ->selectRaw('user_id, MAX(created_at) AS last_login')
            ->groupBy('user_id');

        // Deactivate flagged users who DID NOT sign in within 3 days from deactivation notice
        DB::table('users')
            ->joinSub($latestLogins, 'latest_logins', function ($join) {
                $join->on('users.id', '=', 'latest_logins.user_id');
            })
            ->where('users.is_active', 1)
            ->where('users.is_flagged_for_deactivation', 1)
            ->where('users.role', $userRole)
            ->whereRaw('TIMESTAMPDIFF(DAY, latest_logins.last_login, NOW()) > ?', $noticeDays)
            ->update([
                'is_active' => 0,
                'is_flagged_for_deactivation' => 0
            ]);

        // Set deactivation flag to 0 for users who signed in within 3 days from deactivation notice
        DB::table('users')
            ->joinSub($latestLogins, 'latest_logins', function ($join) {
                $join->on('users.id', '=', 'latest_logins.user_id');
            })
            ->where('users.is_active', 1)
            ->where('users.is_flagged_for_deactivation', 1)
            ->where('users.role', $userRole)
            ->whereRaw('TIMESTAMPDIFF(DAY, latest_logins.last_login, NOW()) <= ?', $noticeDays)
            ->update([
                'is_flagged_for_deactivation' => 0
            ]);

    }

}
