<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SetBreadcrumb
{
    const BREADCRUMB_LIST = [
        'widget-webcheckout' => ['widget-webcheckout.index' => 'Widget y WebCheckout'],
        'widget' => ['widget-webcheckout.widget' => 'Widget'],
        'plugins' => ['plugins.index' => 'Plugins E-commerce'],
        'payment-api' => ['payment-api.index' => 'API de Pagos'],
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $breadcrumb = ['welcome' => 'Inicio'];
        $paths = array_filter(explode('/', $request->path()), function ($value) {
            return $value != '';
        });
        foreach ($paths as $path) {
            if (isset(SetBreadcrumb::BREADCRUMB_LIST[$path])) {
                $breadcrumb = array_merge($breadcrumb, SetBreadcrumb::BREADCRUMB_LIST[$path]);
            }
        }
        View::share('breadcrumb', $breadcrumb);
        return $next($request);
    }
}
