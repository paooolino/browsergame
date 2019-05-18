<?php

namespace BGame\Controller;

class Admin_messageController {
  private $view;
  private $app;
  private $admin;
  private $LeaguesModel;
  private $AdminmenuitemsModel;
  
  public function __construct($view, $app, $admin, $LeaguesModel, $AdminmenuitemsModel) {
    $this->view = $view;
    $this->app = $app;
    $this->admin = $admin;
    $this->LeaguesModel = $LeaguesModel;
    $this->AdminmenuitemsModel = $AdminmenuitemsModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);

    $adminmenuitems = $this->AdminmenuitemsModel->get($args);


    return $this->view->render($response, 'admin-message.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
      "adminmenuitems" => $adminmenuitems,
    ]);
  }
  

}