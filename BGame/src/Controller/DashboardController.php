<?php
namespace BGame\Controller;

class DashboardController {
  private $get;
  private $post;
  private $view;
  private $app;
  
  public function __construct($view, $app) {
    $this->view = $view;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {
    $this->get = $request->getQueryParams();
    $this->post = $request->getParsedBody();
    

    return $this->view->render($response, 'dashboard.php', [
      "templateUrl" => $this->app->templateUrl,
    ]);
  }
  

}