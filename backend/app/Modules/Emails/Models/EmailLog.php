<?php

namespace App\Modules\Emails\Models;

use App\Modules\Emails\Mail\GenericMailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Class EmailQueue
 * @property $status
 * @property $email_to
 * @property $view
 * @property $view_data
 * @property $subject
 * @property $sent_at
 * @package App\Models
 */
class EmailLog extends Model
{
    protected $table = 'email_logs';

    const DB_STATUS_PROCESSED = 'processed';
    const DB_STATUS_PENDING = 'pending';
    const DB_STATUS_PAUSED = 'paused';

    protected $fillable = [
        'view',
        'status',
        'subject',
        'view_data',
    ];

    /**
     * @param string $emailTo
     * @param string $subject
     * @param array $viewData
     * @param string $view
     * @return EmailLog
     * @throws Throwable
     */
    public static function enqueue(string $emailTo,
                                   string $subject,
                                   array  $viewData,
                                   string $view = 'emails.generic'
    ): self
    {
        $emailLog = new self;
        $emailLog->status = self::DB_STATUS_PENDING;
        $emailLog->email_to = trim($emailTo);
        $emailLog->view = $view;
        $emailLog->view_data = json_encode($viewData);
        $emailLog->subject = $subject;

        $environment = app()->environment();

        // overrides for local
        if ($environment !== 'production') {
            $emailLog->subject = "{$subject} - {$environment}";
            $emailLog->status = self::DB_STATUS_PAUSED;
            $emailLog->email_to = 'support@trenchdevs.org';
        }


        if (BlackListedEmail::isBlackListed($emailTo)) {
            /**
             * Don't send to blacklisted emails
             */
            $emailLog->status = self::DB_STATUS_PAUSED;
        }

        $emailLog->saveOrFail();

        return $emailLog;
    }

    /**
     * @param EmailLog $emailQueue
     * @throws Throwable
     */
    public static function sendEntry(EmailLog $emailQueue)
    {

        if (
            $emailQueue->id &&
            $emailQueue->status == self::DB_STATUS_PENDING &&
            empty($emailQueue->sent_at)
        ) {

            $viewData = json_decode($emailQueue->view_data ?? null, true);

            if (empty($viewData)) {
                $viewData = [];
            }

            $genericMailer = new GenericMailer($emailQueue->email_to);
            $genericMailer->viewData = [];
            $genericMailer->view($emailQueue->view, $viewData);
            $genericMailer->subject($emailQueue->subject);

            Mail::to([$emailQueue->email_to])->send($genericMailer);

            $emailQueue->status = self::DB_STATUS_PROCESSED;
            $emailQueue->sent_at = date('Y-m-d H:i:s');
            $emailQueue->saveOrFail();
        }

    }

    /**
     * @throws Throwable
     */
    public function send()
    {
        self::sendEntry($this);
    }

    /**
     * @param int $limit
     * @throws Throwable
     */
    public static function processPending(int $limit = 100)
    {

        $emailLogs = self::query()->where('status', 'pending')
            ->whereNull('sent_at')
            ->limit($limit)
            ->orderBy('id', 'ASC')
            ->get();

        foreach ($emailLogs as $emailLog) {
            /** @var self $emailLog */
            self::sendEntry($emailLog);
        }
    }

    /**
     * @param string $email
     * @param string $subject
     * @param string $message
     * @return static
     * @throws Throwable
     */
    public static function createGenericMail(string $email, string $subject, string $message): self
    {

        $viewData = [
            'name' => 'TrenchDevsAdmin Member',
            'email_body' => $message,
        ];

        return self::enqueue($email, $subject, $viewData, 'emails.generic');
    }
}
