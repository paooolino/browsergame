<?php
namespace BGame\Controller;

class Admin_record_deleteController {
  private $view;
  private $admin;
  private $LeaguesModel;
  private $TableModel;
  private $RecordModel;
  
  public function __construct($view, $admin, $LeaguesModel, $TableModel, $RecordModel) {
    $this->view = $view;
    $this->admin = $admin;
    $this->LeaguesModel = $LeaguesModel;
    $this->TableModel = $TableModel;
    $this->RecordModel = $RecordModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $leagues = $this->LeaguesModel->get($args);

    $table = $this->TableModel->get($args);

    $record = $this->RecordModel->get($args);


    return $this->view->render($response, 'admin-record-delete.php', [
      "templateUrl" => $this->app->templateUrl,
      "leagues" => $leagues,
      "table" => $table,
      "record" => $record,
    ]);
  }
  

}