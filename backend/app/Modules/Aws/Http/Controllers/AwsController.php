<?php

namespace App\Modules\Aws\Http\Controllers;

use App\Modules\Aws\Models\AwsSnsLog;
use App\Modules\Emails\Models\BlackListedEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AwsController extends Controller
{
    public function sns(Request $request)
    {

        $rawContents = $request->getContent();

        try {

            $sns = new AwsSnsLog();

            $sns->identifier = "sns";
            $sns->headers = json_encode($request->header());
            $sns->raw_json = json_encode($request->json());
            $sns->raw_contents = $rawContents;
            $sns->ip = $request->ip();
            $sns->saveOrFail();

            $bodyArr = json_decode($rawContents, true);
            $messageJson = $bodyArr['Message'] ?? null;

            if (empty($messageJson)) {
                throw new \Exception("message json empty");
            }

            $messageArr = json_decode($messageJson, true);

            if (empty($messageArr)) {
                throw new \Exception("cannot parse message json");
            }

            $notificationType = $messageArr['notificationType'] ?? "N/A";

            $recipients = $messageArr['bounce']['bouncedRecipients'] ?? null;

            if (!empty($recipients) && is_array($recipients)) {
                foreach ($recipients as $recipient) {
                    $emailAddress = $recipient['emailAddress'] ?? null;

                    if (empty($emailAddress)) {
                        continue;
                    }

                    $blacklistedEmail = new BlackListedEmail;
                    $blacklistedEmail->email = $emailAddress;
                    $blacklistedEmail->message = "Notification Type: {$notificationType} for email {$emailAddress}";
                    $blacklistedEmail->saveOrFail();
                }
            }

        } catch (\Exception $exception) {
            logger($exception->getMessage());
        }

        return $this->jsonResponse(self::STATUS_SUCCESS, 'Success');
    }
}
