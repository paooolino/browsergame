<?php
namespace BGame\Controller;

class LeagueController {
  private $view;
  private $app;
  private $LeaguesModel;
  private $LeagueModel;
  private $StandingsModel;
  private $FixturesModel;
  
  public function __construct($view, $app, $LeaguesModel, $LeagueModel, $StandingsModel, $FixturesModel) {
    $this->view = $view;
    $this->app = $app;
    $this->LeaguesModel = $LeaguesModel;
    $this->LeagueModel = $LeagueModel;
    $this->StandingsModel = $StandingsModel;
    $this->FixturesModel = $FixturesModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);

    $league = $this->LeagueModel->get($args);

    $standings = $this->StandingsModel->get($args);

    $fixtures = $this->FixturesModel->get($args);


    return $this->view->render($response, 'league.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
      "league" => $league,
      "standings" => $standings,
      "fixtures" => $fixtures,
    ]);
  }
  

}