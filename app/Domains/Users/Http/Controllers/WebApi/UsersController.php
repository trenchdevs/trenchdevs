<?php

namespace App\Domains\Users\Http\Controllers\WebApi;

use App\Domains\Users\Models\User;
use App\Http\Controllers\WebApiController;
use Illuminate\Database\Query\Builder;

class UsersController extends WebApiController
{

    /**
     * Site agnostic endpoint for getting paginated users
     */
    public function getUsers()
    {

        $request = request()->all();

        $pageSize = $request['pageSize'] ?? 10; // validate
        $page = $request['page'] ?? 0; // validate
        $search = $request['search'] ?? 0; // validate
        $filters = $request['filters'] ?? 0; // validate

        $query = User::query();

        if (!empty($search)) {
            $query->where('users.first_name', 'like', "%$search%");
        }

        if (!empty($filters)) {
            foreach ($filters as $filter) {

                $filterKey = $filter['column']['field'] ?? null;
                $filterValue = $filter['value'] ?? null;

                if (empty($filterKey) || !is_string($filterKey)) {
                    continue;
                }

                if (empty($filterValue) || !is_string($filterValue)) {
                    continue;
                }


                switch ($filterKey) {
                    case 'first_name':
                        $query->where('users.first_name', 'like', "%$filterValue%");
                        break;
                    case 'last_name':
                        $query->where('users.last_name', 'like', "%$filterValue%");
                        break;
                    case 'email':
                        $query->where('users.email', 'like', "%$filterValue%");
                        break;
                    case 'username':
                        $query->where('users.username', 'like', "%$filterValue%");
                        break;
                    default:
                        break;
                }

            }
        }

        $totalCount = $query->count();
        $data = $query->limit($pageSize)->offset($page)->get();

        return [
            'data' => $data,
            'page' => $page,
            'totalCount' => $totalCount,
        ];
    }


    /**
     * @param Builder|\Illuminate\Database\Eloquent\Builder $builder
     * @return array
     */
    private function tableResponse($builder)
    {
        return [
            'data' => '',
        ];
    }
}
