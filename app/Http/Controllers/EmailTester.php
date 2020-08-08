<?php

namespace App\Http\Controllers;

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

        $email = 'christopheredrian@gmail.com';
        // $email = 'christopheredrian@trenchdevs.org';
        Mail::to([$email])->send(new \App\Mail\TestMailer());
        dd('done');
    }
}
