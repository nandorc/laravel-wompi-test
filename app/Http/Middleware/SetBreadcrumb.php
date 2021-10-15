<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SetBreadcrumb
{
    const BREADCRUMB_TREE = [
        'index' => ['label' => 'Inicio', 'route' => 'welcome'],
        'widget-webcheckout' => [
            'index' => ['label' => 'Widget y WebCheckout', 'route' => 'widget-webcheckout.index'],
            'widget' => [
                'index' => ['label' => 'Widget', 'route' => 'widget-webcheckout.variant', 'params' => ['variant' => 'widget']]
            ],
            'webcheckout' => [
                'index' => ['label' => 'WebCheckout', 'route' => 'widget-webcheckout.variant', 'params' => ['variant' => 'webcheckout']]
            ]
        ],
        'plugins' => [
            'index' => ['label' => 'Plugins E-commerce', 'route' => 'plugins.index']
        ],
        'payment-api' => [
            'index' => ['label' => 'API de Pagos', 'route' => 'payment-api.index']
        ],
    ];

    private function buildBreadcrumb(array $path, array $breadcrumb = [], array $tree = SetBreadcrumb::BREADCRUMB_TREE)
    {
        $breadcrumb[] = $tree['index'];
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
