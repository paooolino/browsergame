<?php
namespace BGame\Controller;

class Admin_schedule_matchController {
  private $view;
  private $admin;
  private $LeaguesModel;
  
  public function __construct($view, $admin, $LeaguesModel) {
    $this->view = $view;
    $this->admin = $admin;
    $this->LeaguesModel = $LeaguesModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);


    return $this->view->render($response, 'admin-schedule-match.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
    ]);
  }
  

}