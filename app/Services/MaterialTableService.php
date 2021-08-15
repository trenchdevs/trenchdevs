<?php

namespace App\Services;

use App\Domains\Sites\Models\Site;
use Illuminate\Database\Eloquent\Builder;

abstract class MaterialTableService
{

    protected $site;
    protected $query;
    protected $pageSize = 5;
    protected $page = 0;
    /**
     * @var int|mixed
     */
    protected $search;
    /**
     * @var int|mixed
     */
    protected $filters = [];

    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->query = $this->query();
        $this->initializeFromRequest();
    }

    /**
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public abstract function query();

    public abstract function filter();

    public function response()
    {

        $totalCount = $this->query->count();
        $data = $this->query->limit($this->pageSize)->offset($this->page)->get();

        return [
            'data' => $data,
            'page' => $this->page,
            'totalCount' => $totalCount,
        ];
    }

    private function initializeFromRequest()
    {
        $request = request()->all();

        $this->pageSize = $request['pageSize'] ?? 10; // validate
        $this->page = $request['page'] ?? 0; // validate
        $this->search = $request['search'] ?? 0; // validate
        $this->filters = $request['filters'] ?? 0; // validate
    }

}
