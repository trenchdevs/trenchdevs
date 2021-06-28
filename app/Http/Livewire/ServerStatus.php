<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ServerStatus extends Component
{

    public $status = 'Online';

    public function checkStatus() {
        $this->status = $this->status == "Online" ? "Offline" : "Online";
    }

    public function render() {
        return view('livewire.server-status');
    }
}
