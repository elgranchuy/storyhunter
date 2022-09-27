<?php

namespace App\Exceptions;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        $message = ['message' => $e->getMessage()];

        if($e instanceof QueryException) {
            $errorCode = $e->errorInfo[1];
            switch ($errorCode) {
                case 1062: //code duplicate entry
                    $message['errors'] = 'Duplicate Entry';
                    // no break;
                default:
                    $status = Response::HTTP_UNPROCESSABLE_ENTITY;
                    break;
            }
        }
        else if ($e instanceof ValidationException) {
            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
            $message['errors'] = $e->errors();
        } else {
            $foundStatus = $this->getStatusFromException($e);
            $status = $foundStatus > 0 ? $foundStatus : Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response = new JsonResponse($message, $status, []);
        $response->exception = $e;

        return $response;
    }

    protected function getStatusFromException(Throwable $e): int
    {
        foreach (['getStatusCode', 'getHttpStatusCode', 'getCode'] as $method) {
            if (method_exists($e, $method) && is_callable([$e, $method])) {
                return call_user_func([$e, $method]);
            }
        }

        return 0;
    }

}
