<?php

namespace App\Modules\Users\Http\Controllers\WebApi;

use App\Modules\Users\Models\User;
use App\Modules\Users\Services\UsersTable;
use App\Http\Controllers\WebApiController;
use Illuminate\Database\Query\Builder;

class UsersController extends WebApiController
{

    /**
     * Site agnostic endpoint for getting paginated users
     */
    public function getUsers()
    {

        $usersTable = new UsersTable(site());
        return $usersTable->response();
    }

}
