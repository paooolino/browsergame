<?php
namespace BGame\Middleware;

class AppInit {
  private $app;
  
  public function __construct($app) {
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $next) {
    $this->app->templatePath = '/' . $request->getUri()->getBasePath();
    return $next($request, $response);
  }
}