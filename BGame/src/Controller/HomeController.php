<?php
namespace BGame\Controller;

class HomeController {
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
    
    $LeagueslistModel = new \BGame\Model\LeagueslistModel($this->view, $this->app);
    $leagueslist = $LeagueslistModel->get($args);


    return $this->view->render($response, 'home.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagueslist" => $leagueslist,
    ]);
  }
  

}