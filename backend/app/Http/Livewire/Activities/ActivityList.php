<?php

namespace App\Http\Livewire\Activities;

use App\Modules\Activities\Models\ActivityLog;
use Livewire\Component;

class ActivityList extends Component
{

    public $activities = [];
    public $daysToShow = 2;

    public function __construct($id = null) {
        parent::__construct($id);
        $this->activities = ActivityLog::query()
            ->orderBy('id', 'desc')
            ->where('created_at', '>=', now()->subDays($this->daysToShow))
            ->where('title', 'like', '%connected%')
            ->where('title', '!=', '[INFO] Running AutoCompaction...')
            ->get();

    }

    public function render() {
        return view('livewire.activities.activity-list');
    }
}
