<?php
namespace BGame\Controller;

class LoginController {
  private $view;
  private $app;
  private $LeaguesModel;
  
  public function __construct($view, $app, $LeaguesModel) {
    $this->view = $view;
    $this->app = $app;
    $this->LeaguesModel = $LeaguesModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);


    return $this->view->render($response, 'login.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
    ]);
  }
  

}