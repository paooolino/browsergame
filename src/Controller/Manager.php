<?php
namespace BGame\Controller;   
  
final class Manager extends BaseController { 
  public function __invoke($request, $response, $args) {
    return $this->view->render($response, 'manager.php', [
      "templatePath" => $this->templatePath,
      "appVersion" => ""
    ]);
  }
}
