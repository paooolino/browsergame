<?php
namespace BGame\Controller;

class AdminController {
  private $get;
  private $post;
  private $view;
  
  public function __construct($view) {
    $this->view = $view;
  }
  
  public function __invoke($request, $response, $args) {
    $this->get = $request->getQueryParams();
    $this->post = $request->getParsedBody();
    return $this->view->render($response, 'admin.php', [
      "templateUrl" => $this->app->templateUrl
    ]);
  }
  

}