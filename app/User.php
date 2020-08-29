<?php

namespace App;

use App\Models\Users\UserDegree;
use App\Models\Users\UserPortfolioDetail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Throwable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @property UserDegree[] $degrees
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

    public function degrees(){
//        return $this->hasMany('App\Models\Users\UserDegree');
        return $this->hasMany(UserDegree::class);
    }

}
