<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $exception->errors(),
            ], 400);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Ресурс не найден',
            ], 404);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return response()->json([
                'message' => 'Доступ запрещен',
            ], 403);
        }

        if ($exception instanceof HttpException) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], $exception->getStatusCode());
        }

        return response()->json([
            'message' => 'Внутренняя ошибка сервера',
        ], 500);
    }
}