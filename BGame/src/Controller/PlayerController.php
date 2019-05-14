<?php
namespace BGame\Controller;

class PlayerController {
  private $view;
  private $app;
  private $LeaguesModel;
  private $PlayerModel;
  
  public function __construct($view, $app, $LeaguesModel, $PlayerModel) {
    $this->view = $view;
    $this->app = $app;
    $this->LeaguesModel = $LeaguesModel;
    $this->PlayerModel = $PlayerModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);

    $player = $this->PlayerModel->get($args);


    return $this->view->render($response, 'player.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
      "player" => $player,
    ]);
  }
  

}