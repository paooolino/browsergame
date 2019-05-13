<?php
namespace BGame\Controller;

class LeagueController {
  private $view;
  private $app;
  private $LeagueslistModel;
  private $LeagueinfosModel;
  
  public function __construct($view, $app, $LeagueslistModel, $LeagueinfosModel) {
    $this->view = $view;
    $this->app = $app;
    $this->LeagueslistModel = $LeagueslistModel;
    $this->LeagueinfosModel = $LeagueinfosModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagueslist = $this->LeagueslistModel->get($args);

    $leagueinfos = $this->LeagueinfosModel->get($args);


    return $this->view->render($response, 'league.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagueslist" => $leagueslist,
      "leagueinfos" => $leagueinfos,
    ]);
  }
  

}