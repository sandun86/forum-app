<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use App\Libraries\v1\TokenValidator;
use App\Libraries\v1\Helper;

class AdminTokenValidator
{
    private $tokenValidator;
    private $helper;

    public function __construct(
        TokenValidator $tokenValidator,
        Helper $helper
    ) {
        $this->tokenValidator = $tokenValidator;
        $this->helper = $helper;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->headers->has('x-auth-token')) {
            if ($this->tokenValidator->validateAdminToken($request->headers->get('x-auth-token'))) {

                return $next($request);
            } else {
                return $this->helper->response(
                    422,
                    ['message' => 'Authentication has failed.']
                );
            }
        } else {
            return $this->helper->response(
                422,
                ['message' => 'Authentication has failed.']
            );
        }
    }
}
