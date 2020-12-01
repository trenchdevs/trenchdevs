<?php

namespace App\Repositories\News;

interface NewsRepositoryInterface
{
    public function queue(string $body, array $attributes = []): bool;
}
