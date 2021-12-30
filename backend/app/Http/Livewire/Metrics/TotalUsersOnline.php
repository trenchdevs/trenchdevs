<?php

namespace App\Http\Livewire\Metrics;

use Livewire\Component;

class TotalUsersOnline extends Component
{

    public $title = "Members Online";
    public $value = 0;
    public $subtitle = "members currently online";


    public function render()
    {
        return view('livewire.metrics.total-users');
    }
}
