<?php
/* === DEVELOPER BEGIN */
/**
 *  @status 1 
 */
/* === DEVELOPER END */
namespace UserDemo\Controller;

class UserslistController {
  private $UserslistModel;
  private $view;
  private $app;
  
  public function __construct($UserslistModel, $view, $app) {
    $this->UserslistModel = $UserslistModel;
    $this->view = $view;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {  
    $userslist = $this->getdata_userslistModel($request, $args);

    return $this->view->render($response, 'userslist.php', [
      "templateUrl" => $this->app->templateUrl,
      "userslist" => $userslist,
    ]);
  }
  
  /* === DEVELOPER BEGIN */
  private function getdata_userslistModel($request, $args) {
    return $this->UserslistModel->get();
  }
  /* === DEVELOPER END */
}