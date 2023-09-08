<?php

namespace App\Exceptions;

use App\Helpers\MyResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class FailedApiResponse extends Exception
{
    protected $code = 403;

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return MyResponse::failed($this->message, code: $this->code);
    }
}
