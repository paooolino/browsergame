<?php
namespace BGame\Controller;

class LoginController {
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


    return $this->view->render($response, 'login.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagueslist" => $leagueslist,
    ]);
  }
  

}