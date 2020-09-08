<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Class BlackListedEmail
 * @property $email
 * @property $message
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 */
class BlackListedEmail extends Model
{
    protected $table = 'blacklisted_emails';

    protected $fillable = [
        'email',
        'message',
    ];

    /**
     * @param string $email
     * @return bool
     */
    public static function isBlackListed(string $email): bool
    {
        return self::query()->where('email', $email)->count() > 0;
    }

    /**
     * @param string $email
     * @param string $reason
     * @return bool
     * @throws Throwable
     */
    public static function addToBlackListedEmails(string $email, string $reason)
    {
       if (!self::isBlackListed($email)) {
           $blacklisted = new self;
           $blacklisted->email = $email;
           $blacklisted->message = $reason;
           $blacklisted->saveOrFail();
       }

       return true;
    }


}
