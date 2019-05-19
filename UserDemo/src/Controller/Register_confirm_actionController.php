<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Attiva l'utente e redirige al profilo.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace UserDemo\Controller;

class Register_confirm_actionController {
  
  public function __construct() {
  }
  
  public function __invoke($request, $response, $args) {  

    $response = $this->doAction($request, $response, $args);


  }
  
  /* === DEVELOPER BEGIN */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Register_confirm_actionController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DEVELOPER END */
}