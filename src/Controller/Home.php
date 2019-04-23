<?php
namespace BGame\Controller;   
  
final class Home extends BaseController { 
  public function __invoke($request, $response, $args) {
    return $this->view->render($response, 'home.php', [
      "templatePath" => $this->templatePath,
      "appVersion" => ""
    ]);
  }
}
