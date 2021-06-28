<?php

namespace App\Http\Livewire\Users;

use App\User;
use Livewire\Component;

class ListUsers extends Component
{

    public $users = [];

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.users.list-users');
    }
}
