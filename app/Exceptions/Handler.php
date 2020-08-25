<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\Exceptions\OneException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        OneException::class
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
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
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
        return $this->handle($request, $exception);
    }
    
    /*
    *
    */
    public function handle($request, Throwable $exception){

        if($exception instanceOf OneException){
            $data = $exception->toArray();
            $status = $exception->getStatus();
        }

        elseif ($exception instanceOf NotFoundHttpException) {
            $data = array_merge([
                'id'     => 'not_found',
                'status' => '404'
            ], config('errors.not_found'));

            $status = 404;
        }

        elseif ($exception instanceOf MethodNotAllowedHttpException)
       { 
           $data = array_merge([
               'id' => 'method_not_allowed',
               'status' => '405'
           ], config('errors.method_not_allowed'));

           $status = 405;
        }

       elseif ($exception instanceOf \Tymon\JWTAuth\Exceptions\TokenExpiredException)
       { 
           $data = array_merge([
               'id' => 'token_expired',
               'status' => '404'
           ], config('errors.token_expired'));

           $status = 404;
        }

       elseif ($exception instanceOf \Tymon\JWTAuth\Exceptions\TokenInvalidException)
        { 
            $data = array_merge([
                'id' => 'token_invalid',
                'status' => '404'
            ], config('errors.token_invalid'));
 
            $status = 404;
         }

         elseif ($exception instanceOf \Tymon\JWTAuth\Exceptions\JWTException )
        { 
            $data = array_merge([
                'id' => 'token_absent',
                'status' => '500'
            ], config('errors.token_absent'));
 
            $status = 500;
         }

        elseif ($exception instanceOf \Tymon\JWTAuth\Exceptions\UserNotDefinedException)
         { 
             $data = array_merge([
                 'id' => 'user_not_found',
                 'status' => '404'
             ], config('errors.user_not_found'));
  
             $status = '404';
          }
          else{
            $data = array_merge([
                'id' => 'internal_server_error',
                'status' => '500'
            ], config('errors.internal_server_error'));
 
            $status = '500';
          }

        return response()->json($data, $status);
    }

}
