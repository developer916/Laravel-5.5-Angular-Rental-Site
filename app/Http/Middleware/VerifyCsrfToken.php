<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

use Closure;
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

    private $openRoutes = ['depositRelay/getChangeableData','iban-check', 'postTenantDepositRelay','depositRelay/cancel', 'postNewUserWizard', 'existTenants'];
    public function handle($request, Closure $next)
    {
        if(in_array($request->path(), $this->openRoutes)){
            return $next($request);
        }else{
            return parent::handle($request, $next);
        }
    }

    protected $except = [
        'jotform/webhook'
    ];
}
