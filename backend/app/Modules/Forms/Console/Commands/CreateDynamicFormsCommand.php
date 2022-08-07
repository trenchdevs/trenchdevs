<?php

namespace App\Modules\Forms\Console\Commands;

use App\Modules\Forms\Services\DynamicForms;
use Illuminate\Console\Command;

class CreateDynamicFormsCommand extends Command
{

    protected $signature = 'dynamic-forms:create';

    public function handle(): void {
        DynamicForms::newInstance()->createForms();
    }
}
