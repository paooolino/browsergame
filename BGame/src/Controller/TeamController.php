<?php
namespace BGame\Controller;

class TeamController {
  private $view;
  private $app;
  private $LeagueslistModel;
  private $TeaminfosModel;
  
  public function __construct($view, $app, $LeagueslistModel, $TeaminfosModel) {
    $this->view = $view;
    $this->app = $app;
    $this->LeagueslistModel = $LeagueslistModel;
    $this->TeaminfosModel = $TeaminfosModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagueslist = $this->LeagueslistModel->get($args);

    $teaminfos = $this->TeaminfosModel->get($args);


    return $this->view->render($response, 'team.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagueslist" => $leagueslist,
      "teaminfos" => $teaminfos,
    ]);
  }
  

}