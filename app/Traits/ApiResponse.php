<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

trait ApiResponse
{
    /**
     * Success response
     *
     * @param  array  $data
     * @param  string  $message
     * @return JsonResponse
     */
    public function successResponse(array $data, string $message = 'Success'): JsonResponse
    {
        return $this->jsonResponse(200, $message, $data);
    }

    /**
     * Json Response
     *
     * @param  int  $statusCode
     * @param  string  $message
     * @param  array  $data
     * @param  array  $errors
     * @return JsonResponse
     */
    public function jsonResponse(int $statusCode, string $message, array $data, array $errors = []): JsonResponse
    {
        return response()->json([
            'status_code' => $statusCode,
            'message'     => $message,
            'data'        => !empty($data) ? $data : null,
            'errors'      => $errors,
        ]);
    }

    /**
     * Prepare pagination response
     *
     * @param  LengthAwarePaginator  $paginator
     * @return array
     */
    public function preparePaginator(LengthAwarePaginator $paginator): array
    {
        return [
            'record_per_page' => $paginator->perPage(),
            'current_page'    => $paginator->currentPage(),
            'last_page'       => $paginator->lastPage(),
            'total_pages'     => $paginator->lastPage(),
        ];
    }

    /**
     * Response for validation error
     *
     * @param  array  $errors
     * @param  string  $message
     * @return JsonResponse
     */
    public function validationFailedResponse(array $errors, string $message = 'Invalid data'): JsonResponse
    {
        return $this->jsonResponse(422, $message, [], Arr::flatten($errors));
    }

    /**
     * Response for unauthenticated user
     *
     * @param  string  $message
     * @return JsonResponse
     */
    public function unauthenticatedResponse(string $message = 'Unauthenticated'): JsonResponse
    {
        return $this->jsonResponse(401, $message, []);
    }

    /**
     * Response for unauthorized user
     *
     * @param  string  $message
     * @return JsonResponse
     */
    public function forbiddenResponse(string $message = 'This action is unauthorized'): JsonResponse
    {
        return $this->jsonResponse(403, $message, []);
    }

    /**
     * Response for 404 - not found
     *
     * @param  string  $message
     * @return JsonResponse
     */
    public function notFoundResponse(string $message = 'Not found'): JsonResponse
    {
        return $this->jsonResponse(404, $message, []);
    }

    /**
     * Response for 405 - method not allow
     *
     * @param  string  $message
     * @return JsonResponse
     */
    public function methodNotAllowedResponse(string $message = 'Method not allow'): JsonResponse
    {
        return $this->jsonResponse(405, $message, []);
    }

    /**
     * Response for 500 - internal server error
     *
     * @param  string  $message
     * @return JsonResponse
     */
    public function somethingWentWrongResponse(string $message = 'Something went wrong'): JsonResponse
    {
        return $this->jsonResponse(500, $message, []);
    }

    /**
     * Response for custom http response
     * 480 - User is not activated by admin
     *
     * @param  string  $message
     * @return JsonResponse
     */
    public function userNotActivatedResponse(string $message = 'User not activated yet'): JsonResponse
    {
        return $this->jsonResponse(480, $message, []);
    }
}
