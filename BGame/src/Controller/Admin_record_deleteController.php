<?php
namespace BGame\Controller;

class Admin_record_deleteController {
  private $view;
  private $admin;
  private $TableModel;
  private $RecordModel;
  
  public function __construct($view, $admin, $TableModel, $RecordModel) {
    $this->view = $view;
    $this->admin = $admin;
    $this->TableModel = $TableModel;
    $this->RecordModel = $RecordModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $table = $this->TableModel->get($args);

    $record = $this->RecordModel->get($args);


    return $this->view->render($response, 'admin-record-delete.php', [
      "templateUrl" => $this->app->templateUrl,
      "table" => $table,
      "record" => $record,
    ]);
  }
  

}