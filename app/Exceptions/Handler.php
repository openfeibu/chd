<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $response = $this->handle($request,$exception);
        if ($response) {
            return $response;
        }
        return parent::render($request, $exception);
    }
    private function handle($request,$exception)
    {
        switch ($exception) {
            case ($exception instanceof \App\Exceptions\Roles\PermissionDeniedException):
                $resposeJson = [
                    'code' => 403,
                    'url' => '',
                    'message' => $exception->getMessage(),
                ];
                break;
            case ($exception instanceof \Illuminate\Session\TokenMismatchException):
//                return Redirect::back()
//                    ->withErrors(['页面Token 失效，请重新进入'])
//                    ->withMessage('页面Token 失效，请重新进入')
//                    ->withStatus('error')
//                    ->withCode('403');
                $resposeJson = [
                    'code' => 403,
                    'url' => '',
                    'message' => '页面Token 失效，请重新进入',
                ];
                break;
            default:
                return false;
                break;
        }
        if ($request->ajax())
        {
            return $resposeJson;
        }else{
            return response()->view('message.error',$resposeJson);
        }

    }
}
