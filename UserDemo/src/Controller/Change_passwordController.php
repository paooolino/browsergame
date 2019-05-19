<?php

namespace UserDemo\Controller;

class Change_passwordController {
  private $view;
  private $app;
  
  public function __construct($view, $app) {
    $this->view = $view;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {  

    return $this->view->render($response, 'change-password.php', [
      "templateUrl" => $this->app->templateUrl,
    ]);
  }
  

}