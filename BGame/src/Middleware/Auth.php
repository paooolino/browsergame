<?php
namespace BGame\Middleware;

class Auth {
  public function __invoke($request, $response, $next) {
    return $next($request, $response);
  }
}