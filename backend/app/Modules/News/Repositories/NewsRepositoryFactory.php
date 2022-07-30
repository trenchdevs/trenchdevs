<?php

namespace App\Modules\News\Repositories;

class NewsRepositoryFactory
{
    private function __construct()
    {
    }

    public static function getInstance(): NewsRepositoryInterface
    {
        if (!empty(env('AWS_ACCESS_KEY_ID')) &&
            !empty(env('AWS_SECRET_ACCESS_KEY')) &&
            !empty(env('AWS_DEFAULT_REGION')) &&
            !empty(env('AWS_NEWS_SQS_URL'))
        ) {
            return new SqsNewsRepository;
        }

        return new DevelopmentNewsRepository;
    }
}
