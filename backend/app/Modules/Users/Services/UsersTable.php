<?php

namespace App\Modules\Users\Services;

use App\Modules\Users\Models\User;
use App\Services\MaterialTableService;

class UsersTable extends MaterialTableService
{


    public function query()
    {
        return User::query();
    }

    public function filter()
    {
        if (!empty($this->filters)) {
            foreach ($this->filters as $filter) {

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
                        $this->query->where('users.first_name', 'like', "%$filterValue%");
                        break;
                    case 'last_name':
                        $this->query->where('users.last_name', 'like', "%$filterValue%");
                        break;
                    case 'email':
                        $this->query->where('users.email', 'like', "%$filterValue%");
                        break;
                    case 'external_id':
                        $this->query->where('users.external_id', 'like', "%$filterValue%");
                        break;
                    default:
                        break;
                }

            }
        }
    }
}
