<?php
/**
 *  Crea il numero di nuovi giocatori passato dal form.
 *
 *  @status 0 
 */
namespace BGame\Controller;

class Admin_create_players_exController {
  private $router;
  private $admin;
  
  public function __construct($router, $admin) {
    $this->router = $router;
    $this->admin = $admin;
  }
  
  public function __invoke($request, $response, $args) {  

    $action = $this->doAction($request, $response, $args);

    if ($action["status"] == "failure") {
      return $response->withRedirect($this->router->pathFor("ADMIN_MESSAGE"));
    }
    if ($action["status"] == "success") {
      return $response->withRedirect($this->router->pathFor("ADMIN_MESSAGE"));
    }

  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Admin_create_players_exController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DO NOT REMOVE THIS COMMENT */
}