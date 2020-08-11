<?php

namespace App\Http\Controllers;

use App\Mail\GenericMailer;
use App\Mail\TestMailer;
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

                $data = [
                    'name' => 'Christopher Espiritu',
                    'email_body' => '<a>test</a>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).'
                ];

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
        Mail::to([$email])->send(new TestMailer());
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
