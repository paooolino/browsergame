<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Controlla se le credenziali sono corrette. Una eccezione intercetterà il caso di un utente "admin" e redirigerà alla dashboard admin.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace BGame2\Controller;

class Login_actionController {
  private $router;
  private $app;
  
  public function __construct($router, $app) {
    $this->router = $router;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {  

    $response = $this->doAction($request, $response, $args);

    if ($action["status"] == "failure") {
      return $response->withRedirect($this->router->pathFor("ERROR"));
    }
    if ($action["status"] == "success") {
      return $response->withRedirect($this->router->pathFor("DASHBOARD"));
    }

  }
  
  /* === DEVELOPER BEGIN */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Login_actionController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DEVELOPER END */
}