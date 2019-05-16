<?php
namespace BGame\Controller;

class Admin_schedule_matchController {
  private $router;
  private $admin;
  
  public function __construct($router, $admin) {
    $this->router = $router;
    $this->admin = $admin;
  }
  
  public function __invoke($request, $response, $args) {  

    return $this->view->render($response, '.php', [
      "templateUrl" => $this->app->templateUrl,
    ]);
  }
  

}