<?php
namespace BGame\Controller;

class AdminController {
  
  private $view;
  
  public function __construct($view) {
    $this->view = $view;
  }
  
  public function __invoke($request, $response, $args) {
    return $this->view->render($response, 'admin.php', [
      "templateUrl" => $this->app->templateUrl
    ]);
  }
}