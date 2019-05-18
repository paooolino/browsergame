<?php

namespace BGame\Controller;

class MatchController {
  private $view;
  private $app;
  private $LeaguesModel;
  private $MatchModel;
  
  public function __construct($view, $app, $LeaguesModel, $MatchModel) {
    $this->view = $view;
    $this->app = $app;
    $this->LeaguesModel = $LeaguesModel;
    $this->MatchModel = $MatchModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);

    $match = $this->MatchModel->get($args);


    return $this->view->render($response, 'match.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
      "match" => $match,
    ]);
  }
  

}