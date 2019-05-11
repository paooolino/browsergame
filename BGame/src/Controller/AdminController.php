<?php
namespace BGame\Controller;

class AdminController {
  private $get;
  private $view;
  
  public function __construct($view) {
    $this->view = $view;
  }
  
  public function __invoke($request, $response, $args) {
    $this->get = $request->getQueryParams();
    return $this->view->render($response, 'admin.php', [
      "templateUrl" => $this->app->templateUrl
    ]);
  }
  

}