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
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Login_exController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DO NOT REMOVE THIS COMMENT */
}