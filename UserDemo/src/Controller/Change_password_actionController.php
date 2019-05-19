<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Cambia la password dell'utente.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace UserDemo\Controller;

class Change_password_actionController {
  
  public function __construct() {
  }
  
  public function __invoke($request, $response, $args) {  

    $response = $this->doAction($request, $response, $args);


  }
  
  /* === DEVELOPER BEGIN */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Change_password_actionController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DEVELOPER END */
}