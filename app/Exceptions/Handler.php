<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\{App};
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Support\Facades\Log;
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        // 'password',
        // 'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param Throwable $exception
     * @throws Exception
     * @return void
     */
    public function report(Throwable $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param HttpRequest $request
     * @param Throwable $exception
     * @throws Throwable
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception) {
        if ($exception instanceof AccessDeniedException || $exception instanceof NotFoundHttpException) {

            if ($exception instanceof AccessDeniedException) {

                return redirect()->route('error');
            }

            if ($exception instanceof NotFoundHttpException) {
                return redirect()->route('error');
            }
        }

        return parent::render($request, $exception);
    }
}
