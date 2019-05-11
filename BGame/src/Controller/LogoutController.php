<?php
namespace BGame\Controller;

class LogoutController {
  private $get;
  private $post;
  
  public function __construct() {
  }
  
  public function __invoke($request, $response, $args) {
    $this->get = $request->getQueryParams();
    $this->post = $request->getParsedBody();
    $action = $this->doAction();


  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  private function doAction() {
    // create your action here.
  }
  /* === DO NOT REMOVE THIS COMMENT */
}