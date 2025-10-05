<?php

namespace App\Exceptions;

use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class ApiExceptionHandler
{
    public function render(Throwable $e, Request $request): ?JsonResponse
    {
        if (!$request->is('api/*') && !$request->expectsJson()) {
            return null;
        }

        $status = $this->getStatusCode($e);
        $message = $this->getErrorMessage($e, $status);

        $response = ['message' => $message];

        if ($e instanceof ValidationException) {
            $response['errors'] = $e->errors();
        }

        return response()->json($response, $status);
    }

    protected function getStatusCode(Throwable $e): int
    {
        if ($e instanceof HttpException) {
            return $e->getStatusCode();
        }

        if ($e instanceof ValidationException) {
            return Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        if ($e instanceof DomainException) {
            return Response::HTTP_BAD_REQUEST;
        }

        if (method_exists($e, 'getStatusCode')) {
            return $e->getStatusCode();
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    protected function getErrorMessage(Throwable $e, int $status): string
    {
        $message = match ($status) {
            Response::HTTP_NOT_FOUND => 'O recurso solicitado não foi encontrado',
            Response::HTTP_UNAUTHORIZED => 'Não autenticado',
            Response::HTTP_FORBIDDEN => 'Acesso negado',
            Response::HTTP_METHOD_NOT_ALLOWED => 'Método não permitido',
            Response::HTTP_UNPROCESSABLE_ENTITY => 'Erro de validação',
            Response::HTTP_BAD_REQUEST => $e->getMessage(),
            default => 'Ocorreu um erro interno no servidor',
        };

        if (config('app.debug') && $status >= 500) {
            return $e->getMessage();
        }

        return $message;
    }
}
