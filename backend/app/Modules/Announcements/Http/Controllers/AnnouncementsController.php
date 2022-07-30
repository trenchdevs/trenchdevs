<?php

namespace App\Modules\Announcements\Http\Controllers;

use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\Controller;
use App\Modules\Announcements\Models\Announcement;
use App\Modules\Emails\Models\EmailQueue;
use App\Modules\Users\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Throwable;

class AnnouncementsController extends AuthWebController
{
    public function list(): View
    {
        $announcements = Announcement::query()
            ->orderBy('id', 'desc')
            ->simplePaginate();

        return view('announcements.list', [
            'announcements' => $announcements,
        ]);
    }

    public function create()
    {
        $this->adminCheckOrAbort('Feature not enabled for account. Please contact admin if you require elevated access');

        return view('announcements.create');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function announce(Request $request)
    {

        $this->adminCheckOrAbort('Feature not enabled for account. Please contact admin if you require elevated access');

        $this->validate($request, [
            'title'   => 'required',
            'message' => 'required'
        ]);

        /** @var User $user */
        $user = Auth::user();

        $message = $request->message;
        $title   = $request->title;

        $announcement          = new Announcement();
        $announcement->user_id = $user->id;
        $announcement->site_id = site_id();
        $announcement->title   = $title;
        $announcement->status  = 'processed'; // change later on cron
        $announcement->message = $message;
        $announcement->saveOrFail();

        // todo: chris - refactor
        if (!empty($request->emails)) {

            $emails = explode(',', $request->emails);

            if (empty($emails)) {
                abort(404, 'No emails found');
            }

            foreach ($emails as $email) {

                $viewData = [
                    'name'       => null,
                    'email_body' => $message,
                ];

                EmailQueue::queue(
                    trim($email),
                    $title,
                    $viewData,
                    'emails.generic'
                );
            }


        } else {

            $users = User::getTrenchDevsUsers();

            foreach ($users as $user) {

                $viewData = [
                    'name'       => $user->name(),
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

        Session::flash('message', "Successfully created announcement");

        return $this->jsonResponse('success', 'Success!');
    }
}
