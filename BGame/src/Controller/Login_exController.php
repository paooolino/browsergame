<?php
namespace BGame\Controller;

class Login_exController {
  
  private $router;
  
  public function __construct($router) {
    $this->router = $router;
  }
  
  public function __invoke($request, $response, $args) {
    $action = ["status" => "success"];

    if ($action["status"] == "failure") {
      return $response->withRedirect($this->router->pathFor("LOGIN"));
    }
    if ($action["status"] == "success") {
      return $response->withRedirect($this->router->pathFor("DASHBOARD"));
    }

  }
}