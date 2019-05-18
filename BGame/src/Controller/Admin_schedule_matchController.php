<?php
/**
 *  Inserisce il match nel database.
 *
 *  @status 0 
 */
namespace BGame\Controller;

class Admin_schedule_matchController {
  private $router;
  private $admin;
  
  public function __construct($router, $admin) {
    $this->router = $router;
    $this->admin = $admin;
  }
  
  public function __invoke($request, $response, $args) {  

    $response = $this->doAction($request, $response, $args);

  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Admin_schedule_matchController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DO NOT REMOVE THIS COMMENT */
}