<?php
namespace BGame2\Middleware;

class Auth {
  
  private $app;
  
  public function __construct($app) {
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $next) {
    return $next($request, $response);
  }
}