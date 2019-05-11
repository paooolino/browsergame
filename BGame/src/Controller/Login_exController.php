<?php
namespace BGame\Controller;

class Login_exController {
  private $get;
  private $router;
  private $app;
  
  public function __construct($router, $app) {
    $this->router = $router;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {
    $this->get = $request->getQueryParams();
    $action = $this->doAction();

    if ($action["status"] == "failure") {
      return $response->withRedirect($this->router->pathFor("LOGIN"));
    }
    if ($action["status"] == "success") {
      return $response->withRedirect($this->router->pathFor("DASHBOARD"));
    }

  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  private function doAction() {
    // create your action here.
    $username = $this->get["username"];
    $password = $this->get["password"];
    if ($this->app->userExists($username, $password)) {
      $this->app->setAuthCookie();
      return [
        "status" => "failure"
      ];
    } else {
      return [
        "status" => "success"
      ];      
    }
  }
  /* === DO NOT REMOVE THIS COMMENT */
}