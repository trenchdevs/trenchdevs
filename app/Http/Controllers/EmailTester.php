<?php

namespace App\Http\Controllers;

use App\Mail\GenericMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailTester extends Controller
{
    public function test(string $view)
    {

        if (!in_array(env('APP_ENV'), ['local', 'development'])) {
            abort(404);
        }

        $data = [];

        switch ($view) {
            case 'generic':
                $data = ['name' => 'Christopher Espiritu', 'email_message' => 'Email from TrenchDevs'];
                break;

            default:
                abort(404);
        }

        return view("emails.{$view}", $data);
    }

    public function testSend()
    {
        if (!in_array(env('APP_ENV'), ['local', 'development'])) {
            abort(404);
        }

        $email = 'christopheredrian@gmail.com';
        // $email = 'christopheredrian@trenchdevs.org';
        Mail::to([$email])->send(new \App\Mail\TestMailer());
        dd('done');
    }

    public function genericMail()
    {
        $email = 'christopheredrian@gmail.com';

        $genericMail = new GenericMailer( 'Chris', "You got a message from John, login to the platform to check");
        $genericMail->subject('Greetings');

        Mail::to([$email])->send($genericMail);
        echo "Email sent to {$email}";
    }
}
