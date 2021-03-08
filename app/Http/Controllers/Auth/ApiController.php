<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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

        $response = [
            'status' => $status,
            'message' => $message
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response);
    }

    /**
     * @param callable $fn
     * @param string $successMessage
     * @return JsonResponse
     */
    function responseHandler(callable $fn, string $successMessage = 'Success')
    {
        try {

            return response()->json([
                'data' => $fn(),
                'status' => self::STATUS_SUCCESS,
                'message' => $successMessage,
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'status' => self::STATUS_ERROR,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * @return User|null
     */
    public function getLoggedInUser(): ?User
    {
        /** @var User $user */
        $user = Auth::user();
        return $user;
    }

}
