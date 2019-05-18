<?php

namespace BGame\Controller;

class Admin_record_newController {
  private $view;
  private $admin;
  private $LeaguesModel;
  private $TableModel;
  
  public function __construct($view, $admin, $LeaguesModel, $TableModel) {
    $this->view = $view;
    $this->admin = $admin;
    $this->LeaguesModel = $LeaguesModel;
    $this->TableModel = $TableModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);

    $table = $this->TableModel->get($args);


    return $this->view->render($response, 'admin-record-new.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
      "table" => $table,
    ]);
  }
  

}