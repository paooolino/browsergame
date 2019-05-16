<?php
namespace BGame\Controller;

class Register_confirm_exController {
  private $router;
  private $app;
  
  public function __construct($router, $app) {
    $this->router = $router;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {  

    return $this->view->render($response, '.php', [
      "templateUrl" => $this->app->templateUrl,
    ]);
  }
  

}