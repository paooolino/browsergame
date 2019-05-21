<?php
/* === DEVELOPER BEGIN */
/**
 *  @status 1 
 */
/* === DEVELOPER END */
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
    $message = $this->getdata_messageModel($request, $args);

    return $this->view->render($response, 'message.php', [
      "templateUrl" => $this->app->templateUrl,
      "message" => $message,
    ]);
  }
  
  /* === DEVELOPER BEGIN */
  private function getdata_messageModel($request, $args) {
    // call the pure model to retrieve data
    $domain = $request->getQueryParams()['domain'];
    $type = $request->getQueryParams()['type'];
    return $this->MessageModel->get($domain, $type); 
  }
  /* === DEVELOPER END */
}