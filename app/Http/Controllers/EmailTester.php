<?php

namespace App\Http\Controllers;

use App\Mail\GenericMailer;
use App\Mail\TestMailer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Message;
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
//        if (!in_array(env('APP_ENV'), ['local', 'development'])) {
//            abort(404);
//        }
//
//        $email = 'seanygenove@gmail.com';
//        // $email = 'christopheredrian@trenchdevs.org';
//        $mailer = new TestMailer();
//        $recipients = [
//            'christopheredrian@gmail.com',
//            'christopheredrian@trenchdevs.org',
//            'seanygenove@gmail.com',
//
//        ];
//        Mail::to()
//            ->send($mailer);
//        dd('done');

//        Mail::send('emails.generic', ['name' => 'hello', 'email_body' => 'test'], function(Message $message){
//            $message->to('christopheredrian@gmail.com');
//            $message->subject('Subject');
//        });
        $now = Carbon::now();
        $viewData = [
            'name' => 'Christopher Espiritu',
            'email_body' => 'This is an announcement',
        ];
        $gm  = new GenericMailer('christopheredrian@gmail.com', $viewData);
        $gm->subject('Subject - ' . $now->format('Y-m-d H:i:s'));
        $gm->to('christopheredrian@gmail.com');
        return $gm->render();

//        Mail::raw('Helo, this is the message', function(Message $message){
//            $message->to('christopheredrian@gmail.com');
//            $message->subject('Helo');
//        });

    }

}
