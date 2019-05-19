<?php
/* === DEVELOPER BEGIN */
/**
 *  Please add a [desc] attribute to the LOGOUT route.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace BGame\Controller;

class LogoutController {
  
  public function __construct() {
  }
  
  public function __invoke($request, $response, $args) {  

    $response = $this->doAction($request, $response, $args);


  }
  
  /* === DEVELOPER BEGIN */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/LogoutController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DEVELOPER END */
}