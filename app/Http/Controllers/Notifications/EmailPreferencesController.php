<?php

namespace App\Http\Controllers\Notifications;

use App\BlackListedEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class EmailPreferencesController extends Controller
{

    public function showUnsubscribeForm()
    {
        return view('notifications.emails.unsubscribe');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function unsubscribe(Request $request)
    {

        $this->validate($request, [
            'email' => [
                'required',
                'exists:users',
            ]
        ]);

        $email = $request->get('email');

        if (BlackListedEmail::isBlackListed($email)) {
            throw ValidationException::withMessages([
                'email' => "You're already unsubscribed from the TrenchDevs notifications"
            ]);
        }

        BlackListedEmail::addToBlackListedEmails($email, 'User unsubscribes from emails');

        return back()->with('message', 'Successfully unsubscribed you from all notification emails on TrenchDevs');

    }
}
