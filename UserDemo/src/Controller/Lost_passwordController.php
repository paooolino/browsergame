<?php

namespace UserDemo\Controller;

class Lost_passwordController {
  private $view;
  private $app;
  
  public function __construct($view, $app) {
    $this->view = $view;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {  

    return $this->view->render($response, 'lost-password.php', [
      "templateUrl" => $this->app->templateUrl,
    ]);
  }
  

}