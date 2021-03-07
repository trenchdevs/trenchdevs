<?php

namespace App\Repositories\Notes;

use App\Models\Notes\Note;
use Illuminate\Contracts\Pagination\Paginator;
use InvalidArgumentException;

class NotesRepository
{

    /**
     * @param array $filters
     * @return Paginator
     */
    public function all(array $filters = [])
    {

        // type is required
        $noteType = $filters['type'] ?? null;
        $this->isValidTypeOrFail($noteType);

        // base query
        $query = Note::query()->where('type', $noteType);

        foreach ($filters as $filterKey => $filterValue) {

            switch ($filterKey) {
                case 'date':

                    if (!is_valid_date($filterValue, 'Y-m-d')) {
                        throw new InvalidArgumentException("Invalid date format {$filterValue}");
                    }

                    $query->where('date', $filterValue);
                    break;
                default:
                    break;
            }
        }

        return $query->simplePaginate(10);
    }

    /**
     * @param string|null $type
     */
    private function isValidTypeOrFail(string $type = null)
    {
        if (empty($type) || !is_string($type) || !Note::isValidType($type)) {
            throw new InvalidArgumentException("Note type (eg. note|note_template) is required.");
        }

    }

}
