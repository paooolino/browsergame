<?php
/**
 *  Please add a [desc] attribute to the LOGOUT route.
 *
 *  @status 0 
 */
namespace BGame\Controller;

class LogoutController {
  
  public function __construct() {
  }
  
  public function __invoke($request, $response, $args) {  

    $action = $this->doAction($request, $response, $args);


  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/LogoutController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DO NOT REMOVE THIS COMMENT */
}