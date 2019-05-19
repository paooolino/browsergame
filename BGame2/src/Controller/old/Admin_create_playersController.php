<?php

namespace BGame2\Controller;

class Admin_create_playersController {
  private $view;
  private $app;
  private $admin;
  private $LeaguesModel;
  private $AdminmenuitemsModel;
  private $CountsModel;
  
  public function __construct($view, $app, $admin, $LeaguesModel, $AdminmenuitemsModel, $CountsModel) {
    $this->view = $view;
    $this->app = $app;
    $this->admin = $admin;
    $this->LeaguesModel = $LeaguesModel;
    $this->AdminmenuitemsModel = $AdminmenuitemsModel;
    $this->CountsModel = $CountsModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);

    $adminmenuitems = $this->AdminmenuitemsModel->get($args);

    $counts = $this->CountsModel->get($args);


    return $this->view->render($response, 'admin-create-players.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
      "adminmenuitems" => $adminmenuitems,
      "counts" => $counts,
    ]);
  }
  

}