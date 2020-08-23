<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\GenericMailer;
use App\Models\Announcement;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Throwable;

class AnnouncementsController extends Controller
{
    public function list()
    {
        $announcements = Announcement::paginate();
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
        // save meta data
        $announcement->saveOrFail();

        if (!empty($request->emails)) {

            $emails = explode(',', $request->emails);

            if (empty($emails)) {
                abort(404, 'No emails found');
            }

            $genericMail = new GenericMailer($message, null);
            $genericMail->subject($title);

            Mail::to($emails)
                ->send($genericMail);

        } else {

            $users = User::getTrenchDevsUsers();

            foreach ($users as $user) {
                $genericMail = new GenericMailer($message, $user->name());
                $genericMail->subject($title);
                Mail::to([$user->email])
                    ->send($genericMail);
            }
        }

        return $this->jsonResponse(200, 'Success!');
    }
}
