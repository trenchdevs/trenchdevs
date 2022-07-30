<?php

namespace App\Http\Livewire\Metrics;

use App\Modules\Users\Models\User;
use Livewire\Component;

class TotalUsers extends Component
{
    public $title = "Total Members";
    public $value = 0;
    public $subtitle = "total registered users";

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->value = User::query()->count();
    }

    public function render()
    {
        return view('livewire.metrics.total-users');
    }
}
