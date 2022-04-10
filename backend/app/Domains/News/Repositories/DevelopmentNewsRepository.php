<?php

namespace App\Domains\News\Repositories;

use Illuminate\Support\Facades\Log;

class DevelopmentNewsRepository implements NewsRepositoryInterface
{


    public function queue(string $body, array $attributes = []): bool
    {
        $attributesJson = json_encode($attributes);
        Log::info("Queueing: Body: {$body}. Attributes: {$attributesJson}");
        return true;
    }
}
