<?php

namespace App\Modules\News\Repositories;

interface NewsRepositoryInterface
{
    public function queue(string $body, array $attributes = []): bool;
}
