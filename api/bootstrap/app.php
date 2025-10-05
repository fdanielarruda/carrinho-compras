<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (Throwable $e, Request $request) {

            if ($request->is('api/*') || $request->expectsJson()) {

                $status = 500;

                if ($e instanceof HttpException) {
                    $status = $e->getStatusCode();
                } elseif (method_exists($e, 'getStatusCode')) {
                    $status = $e->getStatusCode();
                }

                $message = match ($status) {
                    404     => 'O recurso solicitado não foi encontrado.',
                    401     => 'Não autenticado.',
                    403     => 'Acesso negado.',
                    405     => 'Método não permitido.',
                    422     => 'Erro de validação.',
                    default => 'Ocorreu um erro interno no servidor.',
                };

                if (config('app.debug') && $status === 500) {
                    $message = $e->getMessage();
                }

                $response = [
                    'message' => $message,
                ];

                if ($e instanceof ValidationException) {
                    $response['errors'] = $e->errors();
                }

                return response()->json($response, $status);
            }
        });
    })->create();
