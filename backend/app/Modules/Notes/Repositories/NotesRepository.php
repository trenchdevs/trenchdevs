<?php

namespace App\Modules\Notes\Repositories;

use App\Modules\Notes\Models\Note;
use App\Modules\Users\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Throwable;

class NotesRepository
{

    /**
     * @param User $user
     * @param array $filters
     * @return Paginator
     */
    public function all(User $user, array $filters = [])
    {

        // type is required
        $noteType = $filters['type'] ?? null;
        $this->isValidTypeOrFail($noteType);

        // base query
        $query = Note::query()
            ->where('type', $noteType)
            ->where('user_id', $user->id);

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

    /**
     * @param User $user
     * @param array $data
     * @return bool
     * @throws ValidationException
     * @throws Throwable
     */
    public function upsert(User $user, array $data): bool
    {

        $noteId = $data['id'] ?? null;

        if (!empty($noteId)) {

            $note = Note::query()->find($noteId);

            if (empty($note)) {
                throw new InvalidArgumentException("Note id not found");
            }

            if ($note->user_id !== $user->id) {
                throw new InvalidArgumentException("Forbidden");
            }

        } else {
            $note = new Note;
        }

        $validator = Validator::make($data, [
            'title' => 'required',
            'type' => 'required',
            'date' => 'required|date',
            'contents' => 'required', // todo: validation logic
        ]);

        $validator->validate();

        $data['user_id'] = $user->id;
        $note->fill($data);
        return $note->saveOrFail($data);
    }

}
