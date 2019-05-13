<?php
namespace BGame\Controller;

class LeagueinfosController {
  private $get;
  private $post;
  private $db;
  
  public function __construct($db) {
    $this->db = $db;
  }
  
  public function __invoke($request, $response, $args) {
    $this->get = $request->getQueryParams();
    $this->post = $request->getParsedBody();
    

    return $this->view->render($response, '.php', [
      "templateUrl" => $this->app->templateUrl,
    ]);
  }
  

}