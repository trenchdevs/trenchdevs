<?php

namespace App\Models;

use App\Mail\GenericMailer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Throwable;

class EmailQueue extends Model
{
    protected $table = 'email_queues';

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
     * @return bool
     * @throws Throwable
     */
    public static function queue(string $emailTo,
                                 string $subject,
                                 array $viewData,
                                 string $view = 'emails.generic'
    ): self
    {
        $queue = new self;
        $queue->status = 'pending';
        $queue->email_to = trim($emailTo);
        $queue->view = $view;
        $queue->view_data = json_encode($viewData);
        $queue->subject = $subject;

        $queue->saveOrFail();

        return $queue;
    }

    /**
     * @param EmailQueue $emailQueue
     * @throws Throwable
     */
    public static function sendEntry(EmailQueue $emailQueue)
    {

        if (
            $emailQueue->id &&
            $emailQueue->status == 'pending' &&
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
            $emailQueue->status = 'processed';
            $emailQueue->sent_at = date('Y-m-d H:i:s');
            $emailQueue->saveOrFail();
        }

    }

    /**
     * @throws Throwable
     */
    public function send(){
        return self::sendEntry($this);
    }

    /**
     * @param int $limit
     * @throws Throwable
     */
    public static function processPending(int $limit = 100)
    {

        $queues = self::where('status', 'pending')
            ->whereNull('sent_at')
            ->limit($limit)
            ->orderBy('id', 'ASC')
            ->get();

        foreach ($queues as $queue) {
            /** @var self $queue */
            self::sendEntry($queue);
        }
    }
}
