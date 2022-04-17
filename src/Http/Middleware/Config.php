<?php

namespace L5Swagger\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use L5Swagger\ConfigFactory;
use L5Swagger\Exceptions\L5SwaggerException;

class Config
{
    /**
     * @param  $request
     * @param  Closure  $next
     * @return mixed
     *
     * @throws L5SwaggerException
     */
    public function handle($request, Closure $next)
    {
        $actions = $request->route()->getAction();

        $documentation = $actions['l5-swagger.documentation'];

        $configFactory = resolve(ConfigFactory::class);
        $config = $configFactory->documentationConfig($documentation);

        $request->offsetSet('documentation', $documentation);
        $request->offsetSet('config', $config);
        $app = resolve(Application::class);
        $app->instance('request', $request);

        return $next($request);
    }
}
