<?php
namespace BGame\Controller;

class AdminController {
  private $view;
  private $app;
  private $LeaguesModel;
  private $AdminmenuitemsModel;
  
  public function __construct($view, $app, $LeaguesModel, $AdminmenuitemsModel) {
    $this->view = $view;
    $this->app = $app;
    $this->LeaguesModel = $LeaguesModel;
    $this->AdminmenuitemsModel = $AdminmenuitemsModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);

    $adminmenuitems = $this->AdminmenuitemsModel->get($args);


    return $this->view->render($response, 'admin.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
      "adminmenuitems" => $adminmenuitems,
    ]);
  }
  

}