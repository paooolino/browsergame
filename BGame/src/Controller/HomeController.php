<?php
namespace BGame\Controller;

class HomeController {
  private $view;
  private $app;
  private $LeagueslistModel;
  
  public function __construct($view, $app, $LeagueslistModel) {
    $this->view = $view;
    $this->app = $app;
    $this->LeagueslistModel = $LeagueslistModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagueslist = $this->LeagueslistModel->get($args);


    return $this->view->render($response, 'home.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagueslist" => $leagueslist,
    ]);
  }
  

}