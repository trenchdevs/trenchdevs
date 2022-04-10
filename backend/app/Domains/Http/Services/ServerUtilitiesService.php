<?php

namespace App\Domains\Http\Services;

class ServerUtilitiesService
{

    public function ping(string $host, int $port, int $timeoutInSeconds = 3): bool
    {
        $success = false;
        if ($fp = fsockopen($host, $port, $errCode, $errStr, $timeoutInSeconds)) {
            $success = true;
        }

        fclose($fp);

        return $success;
    }

}
