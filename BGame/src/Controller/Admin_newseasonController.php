<?php
/* === DEVELOPER BEGIN */
/**
 *  Please add a [desc] attribute to the ADMIN_NEWSEASON route.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace BGame\Controller;

class Admin_newseasonController {
  private $router;
  private $admin;
  
  public function __construct($router, $admin) {
    $this->router = $router;
    $this->admin = $admin;
  }
  
  public function __invoke($request, $response, $args) {  

    $response = $this->doAction($request, $response, $args);


  }
  
  /* === DEVELOPER BEGIN */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Admin_newseasonController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DEVELOPER END */
}