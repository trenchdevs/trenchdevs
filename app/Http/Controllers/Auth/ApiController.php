<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;

class ApiController extends Controller
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    public function getValidApiStatuses()
    {
        return [
            self::STATUS_ERROR,
            self::STATUS_SUCCESS,
        ];
    }

    /**
     * @param string $status
     * @throws InvalidArgumentException
     */
    private function validStatusOrFail(string $status)
    {

        if (!in_array($status, $this->getValidApiStatuses())) {
            throw new InvalidArgumentException();
        }

    }

    /**
     * @param string $status
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public function jsonApiResponse(string $status, string $message, $data = []): JsonResponse
    {

        $this->validStatusOrFail($status);

        $statusData = [
            'status' => $status,
            'message' => $message
        ];

        return response()
            ->json(array_merge($statusData, ['data' => $data]));
    }

}
