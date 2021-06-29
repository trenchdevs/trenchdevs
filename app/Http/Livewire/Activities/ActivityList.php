<?php

namespace App\Http\Livewire\Activities;

use App\Models\Activities\Activity;
use Livewire\Component;

class ActivityList extends Component
{

    public $activities = [];

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->activities = Activity::query()->orderBy('id', 'desc')->limit(20)->get();

    }

    public function render()
    {
        return view('livewire.activities.activity-list');
    }
}
