<?php
namespace BGame\Controller;

class Login_exController {
  private $router;
  private $app;
  
  public function __construct($router, $app) {
    $this->router = $router;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {  

    $action = $this->doAction($request, $response, $args);

    if ($action["status"] == "failure") {
      return $response->withRedirect($this->router->pathFor("ERROR"));
    }
    if ($action["status"] == "success") {
      return $response->withRedirect($this->router->pathFor("DASHBOARD"));
    }

  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  private function doAction() {
    // create your action here.
    $username = $this->post["username"];
    $password = $this->post["password"];
    if ($this->app->userExists($username, $password)) {
      $this->app->setAuthCookie($username, $password);
      return [
        "status" => "success"
      ];
    } else {
      return [
        "status" => "failure"
      ];      
    }
  }
  /* === DO NOT REMOVE THIS COMMENT */
}