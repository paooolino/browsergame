<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Inserisce l'utente nel db, con stato non attivo e manda la mail di registrazione.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace UserDemo\Controller;

class Register_actionController {
  
  public function __construct() {
  }
  
  public function __invoke($request, $response, $args) {  

    $response = $this->doAction($request, $response, $args);


  }
  
  /* === DEVELOPER BEGIN */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Register_actionController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DEVELOPER END */
}