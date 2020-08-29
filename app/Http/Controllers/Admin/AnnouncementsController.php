<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\EmailQueue;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Throwable;

class AnnouncementsController extends Controller
{
    public function list()
    {
        $announcements = Announcement::orderBy('id', 'desc')
            ->paginate();

        return view('announcements.list', [
            'announcements' => $announcements,
        ]);
    }

    public function create()
    {
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

        $this->validate($request, [
            'title' => 'required',
            'message' => 'required'
        ]);

        $user = Auth::user();

        if ($user->role !== User::ROLE_SUPER_ADMIN) {
            abort(403);
        }

        $message = $request->message;
        $title = $request->title;

        $announcement = new Announcement();
        $announcement->user_id = $user->id;
        $announcement->account_id = 1;
        $announcement->title = $title;
        $announcement->status = 'processed'; // change later on cron
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
                    'name' => null,
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
                    'name' => $user->name(),
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
