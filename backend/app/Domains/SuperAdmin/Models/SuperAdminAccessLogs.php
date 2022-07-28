<?php

namespace App\Domains\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Throwable;

class SuperAdminAccessLogs extends Model
{
    protected $table = 'superadmin_access_logs';

    protected $fillable = [
        'user_id',
        'ip',
        'action',
        'message',
        'meta_data',
    ];

    /**
     * @param int $userId
     * @param string $ip
     * @param string $action
     * @param string $message
     * @return SuperAdminAccessLogs
     * @throws Throwable
     */
    public static function log(int $userId, string $ip, string $action, string $message): SuperAdminAccessLogs
    {
        $log = new self;
        $log->fill([
            'user_id' => $userId,
            'ip' => $ip,
            'action' => $action,
            'message' => $message
        ]);
        $log->saveOrFail();

        return $log;
    }

    /**
     * @param string $meta
     * @return $this
     * @throws Throwable
     */
    public function saveMeta(string $meta): SuperAdminAccessLogs
    {
        if (!empty($meta)) {
            $this->fill(['meta_data' => $meta]);
            $this->saveOrFail();
        }

        return $this;
    }
}
