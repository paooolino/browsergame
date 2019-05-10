<?php
namespace BGame\Controller;

class Login_exController {
  
  private $router;
  
  public function __construct($router) {
    $this->router = $router;
  }
  
  public function __invoke($request, $response, $args) {
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
    die("please create the action by editing the /src/Controller/Login_exController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DO NOT REMOVE THIS COMMENT */
}