<?php

namespace App\Modules\Announcements\Http\Controllers;

use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\Controller;
use App\Modules\Announcements\Models\Announcement;
use App\Modules\Emails\Models\EmailLog;
use App\Modules\Users\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Inertia\Response;
use InvalidArgumentException;
use Throwable;

class AnnouncementsController extends AuthWebController
{
    /**
     * @throws Exception
     */
    public function displayAnnouncements(): Response
    {
        return $this->inertiaRender('Announcements/AnnouncementsList', [
            'data' => Announcement::query()
                ->orderBy('id', 'desc')
                ->paginate(),
        ]);
    }

    /**
     * @throws Exception
     */
    public function displayCreateForm(): Response
    {
        return $this->inertiaRender('Announcements/CreateAnnouncement');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function createAnnouncement(Request $request): RedirectResponse
    {
        $this->adminCheckOrAbort();

        $this->validate($request, [
            'title' => 'required',
            'message' => 'required',
            'emails' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $message = $request->input('message');
            $title = $request->input('title');

            $announcement = new Announcement();
            $announcement->fill(array_merge($request->all(), [
                'user_id' => user_id(),
                'site_id' => site_id(),
                'status' => 'processed', // feature needs manual intervention for now
            ]));

            $announcement->saveOrFail();

            if (empty($emailsCsv = $request->input('emails')) || empty($emailsCsv = explode(',', $emailsCsv))) {
                throw new InvalidArgumentException("Emails Required");
            }

            $users = User::query()->whereIn('email', $emailsCsv);

            if ($users->count() <= 0) {
                throw new InvalidArgumentException("Users specified not found.");
            }

            $users->chunkById(10, function (Collection $users) use ($message, $title) {
                /** @var User $user */
                foreach ($users as $user) {
                    EmailLog::queue(
                        trim($user->email),
                        $title,
                        ['name' => $user->name, 'email_body' => $message],
                    );
                }
            });

            DB::commit();
            Session::flash('message', "Successfully created announcement");

        } catch (Exception $exception) {
            DB::rollBack();
            abort('400', $exception->getMessage());
        }

        return redirect(route('dashboard.announcements'));
    }
}
