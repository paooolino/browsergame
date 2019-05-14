<?php
namespace BGame\Controller;

class Admin_loginController {
  private $view;
  private $admin;
  private $TablesModel;
  
  public function __construct($view, $admin, $TablesModel) {
    $this->view = $view;
    $this->admin = $admin;
    $this->TablesModel = $TablesModel;
  }
  
  public function __invoke($request, $response, $args) {  
    $tables = $this->TablesModel->get($args);


    return $this->view->render($response, 'admin-login.php', [
      "templateUrl" => $this->app->templateUrl,
      "tables" => $tables,
    ]);
  }
  

}