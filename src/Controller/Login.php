<?php
namespace BGame\Controller;   
  
final class Login extends BaseController { 
  public function __invoke($request, $response, $args) {
    return $this->view->render($response, 'page.php', [
      "templatePath" => $this->templatePath,
      "appVersion" => ""
    ]);
  }
}
