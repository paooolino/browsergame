<?php
namespace BGame\Controller;

class TeamController {
  private $view;
  private $app;
  private $LeaguesModel;
  private $TeamModel;
  
  public function __construct($view, $app, $LeaguesModel, $TeamModel) {
    $this->view = $view;
    $this->app = $app;
    $this->LeaguesModel = $LeaguesModel;
    $this->TeamModel = $TeamModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);

    $team = $this->TeamModel->get($args);


    return $this->view->render($response, 'team.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
      "team" => $team,
    ]);
  }
  

}