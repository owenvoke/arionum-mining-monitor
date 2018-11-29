<?php

namespace App\Exceptions;

use App\Exceptions\Api\InvalidReportTokenException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request
     * @param Exception $exception
     *
     * @return Response
     */
    public function render($request, Exception $exception): Response
    {
        if ($exception instanceof InvalidReportTokenException || $exception instanceof MiningMonitorException) {
            Log::error($exception->getMessage());
            return $this->returnJsonExceptionResponse($exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * @param Exception $exception
     * @param int|null  $statusCode
     * @return Response
     */
    private function returnJsonExceptionResponse(Exception $exception, ?int $statusCode = 400): Response
    {
        $statusCode = $statusCode ?? 500;

        return Response::create([
            'coin' => config('arionum.report.coin'),
            'data' => $exception->getMessage(),
            'status' => 'error',
        ])->setStatusCode($statusCode);
    }
}
