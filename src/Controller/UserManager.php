<?php
namespace BGame\Controller;   
  
final class UserManager extends BaseController { 
  public function __invoke($request, $response, $args) {
    return $this->view->render($response, '.php', [
      "templatePath" => $this->templatePath,
      "appVersion" => ""
    ]);
  }
}
