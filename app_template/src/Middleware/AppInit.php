<?php
namespace NS\Middleware;

class AppInit {
  
  private $app;
  
  public function __construct($app) {
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $next) {
    $this->app->baseUrl = $request->getUri()->getBaseUrl();
    return $next($request, $response);
  }
}