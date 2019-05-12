<?php
namespace BGame\Controller;

class LeagueController {
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
    
    $LeagueslistModel = new \BGame\Model\LeagueslistModel();
    $leagueslist = $LeagueslistModel->get();
    $LeagueinfosModel = new \BGame\Model\LeagueinfosModel();
    $leagueinfos = $LeagueinfosModel->get();

    return $this->view->render($response, 'league.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagueslist" => $leagueslist,
      "leagueinfos" => $leagueinfos,
    ]);
  }
  

}