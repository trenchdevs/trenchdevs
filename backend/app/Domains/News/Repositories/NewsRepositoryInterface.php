<?php

namespace App\Domains\News\Repositories;

interface NewsRepositoryInterface
{
    public function queue(string $body, array $attributes = []): bool;
}
