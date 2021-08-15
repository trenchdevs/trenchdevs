<?php

namespace App\Domains\Users\Http\Controllers\WebApi;

use App\Domains\Users\Models\User;
use App\Domains\Users\Services\UsersTable;
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
