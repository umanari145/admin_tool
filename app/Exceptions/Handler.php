<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception)) {
            //何らかのerror-reportに ex sentryなど
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (!$request->is('api/*')) {
            // API以外は何もしない(通常通り画面に出す)
            return parent::render($request, $exception);
        } else if ($exception instanceof NotFoundHttpException) {
            // Route が存在しない
            // 画面を出すのではなくJSONを出す
            return response()->json(['error' => 'Not found'], 404);
        } else if ($exception instanceof CustomException) {
            // 画面を出すのではなくJSONを出す(customizeしたい場合のレスポンス)
            return response()->json(['error' => 'ServerError'], 500);
        } else {
            return parent::render($request, $exception);
        }
    }
}
