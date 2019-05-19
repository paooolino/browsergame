<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Inserisce l'utente nel database, con stato inattivo. Invia la mail di registrazione.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace BGame2\Controller;

class Register_exController {
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
      return $response->withRedirect($this->router->pathFor("REGISTER_CONFIRM"));
    }

  }
  
  /* === DEVELOPER BEGIN */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Register_exController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DEVELOPER END */
}