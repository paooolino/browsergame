<?php
/* === DEVELOPER BEGIN */
/**
 *  Pagina di atterraggio del link di conferma inviato via mail. Controlla il codice e se corrisponde, attiva l'utente.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace BGame\Controller;

class Register_confirm_exController {
  private $router;
  private $app;
  
  public function __construct($router, $app) {
    $this->router = $router;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {  

    $response = $this->doAction($request, $response, $args);

    if ($action["status"] == "failure") {
      return $response->withRedirect($this->router->pathFor("MESSAGE"));
    }
    if ($action["status"] == "success") {
      return $response->withRedirect($this->router->pathFor("MESSAGE"));
    }

  }
  
  /* === DEVELOPER BEGIN */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Register_confirm_exController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DEVELOPER END */
}