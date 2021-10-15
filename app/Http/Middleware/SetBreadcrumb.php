<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SetBreadcrumb
{
    const BREADCRUMB_TREE = [
        'index' => ['welcome' => 'Inicio'],
        'widget-webcheckout' => [
            'index' => ['widget-webcheckout.index' => 'Widget y WebCheckout'],
            'widget' => [
                'index' => ['widget-webcheckout.widget' => 'Widget']
            ],
        ],
        'plugins' => [
            'index' => ['plugins.index' => 'Plugins E-commerce']
        ],
        'payment-api' => [
            'index' => ['payment-api.index' => 'API de Pagos']
        ],
    ];

    private function buildBreadcrumb(array $path, array $breadcrumb = [], array $tree = SetBreadcrumb::BREADCRUMB_TREE)
    {
        $breadcrumb = array_merge($breadcrumb, $tree['index']);
        if (sizeof($path) > 0 && isset($tree[$path[0]])) {
            $tree = $tree[$path[0]];
            array_shift($path);
            return $this->buildBreadcrumb($path, $breadcrumb, $tree);
        } else {
            return $breadcrumb;
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $path = array_filter(explode('/', $request->path()), function ($value) {
            return $value != '';
        });
        View::share('breadcrumb', $this->buildBreadcrumb($path));
        return $next($request);
    }
}
