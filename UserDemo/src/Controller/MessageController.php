<?php

namespace UserDemo\Controller;

class MessageController {
  private $MessageModel;
  private $view;
  private $app;
  
  public function __construct($MessageModel, $view, $app) {
    $this->MessageModel = $MessageModel;
    $this->view = $view;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {  

    return $this->view->render($response, 'message.php', [
      "templateUrl" => $this->app->templateUrl,
      "message" => $message,
    ]);
  }
  

}