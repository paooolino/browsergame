<?php
namespace BGame\Controller;

class Admin_tableController {
  private $view;
  private $admin;
  private $TableModel;
  
  public function __construct($view, $admin, $TableModel) {
    $this->view = $view;
    $this->admin = $admin;
    $this->TableModel = $TableModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $table = $this->TableModel->get($args);


    return $this->view->render($response, 'admin-table.php', [
      "templateUrl" => $this->app->templateUrl,
      "table" => $table,
    ]);
  }
  

}