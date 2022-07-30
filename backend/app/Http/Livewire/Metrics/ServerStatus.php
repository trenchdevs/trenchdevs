<?php

namespace App\Http\Livewire\Metrics;

use App\Modules\Sites\Models\Site;
use App\Modules\Http\Services\ServerUtilitiesService;
use Livewire\Component;

class ServerStatus extends Component
{

    private $serverUtilities;
    public $status = "Unknown";
    public $host;

    public $message = "";

    /** @var Site|null */
    private $site;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->serverUtilities = new ServerUtilitiesService();
        $this->site = Site::getInstance();
        $this->host = $this->site->getConfigValueByKey("SERVER_TO_PING");
    }

    public function checkStatus()
    {

        if (!empty($this->host)) {

            if ($this->serverUtilities->ping($this->host, 80)) {
                $this->status = "Online";
            } else {
                $this->status = "Offline";
            }

            $this->message = "";
        } else {
            $this->message = "System was not able to find server";
        }

    }

    public function render()
    {
        return view('livewire.metrics.server-status');
    }
}
