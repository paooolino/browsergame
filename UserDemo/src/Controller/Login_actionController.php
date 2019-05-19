<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Dati username e password in input, verifica se l'utente esiste nel database ed in caso positivo setta il cookie di login.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace UserDemo\Controller;

class Login_actionController {
  
  public function __construct() {
  }
  
  public function __invoke($request, $response, $args) {  

    $response = $this->doAction($request, $response, $args);


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