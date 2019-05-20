<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Inserisce l'utente nel db, con stato non attivo e manda la mail di registrazione.
 *
 *  @status 1 
 */
/* === DEVELOPER END */
namespace UserDemo\Controller;

class Register_actionController {
  private $auth;
  private $router;
  private $app;
  
  public function __construct($auth, $router, $app) {
    $this->auth = $auth;
    $this->router = $router;
    $this->app = $app;
  }
  
  public function __invoke($request, $response, $args) {  

    $action_result = $this->doAction($request, $args);
    $redir = $this->router->pathFor($action_result["route_to"]);
    if (isset($action_result["qs"])) {
      $redir .= "?" . http_build_query($action_result["qs"]);
    }
    return $response->withRedirect($redir);

  }
  
  /* === DEVELOPER BEGIN */
  private function doAction($request, $args) {
    $email = $request->getParsedBody()["email"];
    $password = $request->getParsedBody()["password"];
    $password_check = $request->getParsedBody()["password_check"];

    if ($password == "") {
      return $this->app->redirDescriptor("MESSAGE", "register", "empty_password");
    }
    
    if (strlen($password) < 8) {
      return $this->app->redirDescriptor("MESSAGE", "register", "short_password");
    }
    
    if ($password != $password_check) {
      return $this->app->redirDescriptor("MESSAGE", "register", "password_mismatch");
    }
    
    $result = $this->auth->register_user($email, password_hash($password, PASSWORD_DEFAULT));
    if ($result === false) {
      return $this->app->redirDescriptor("MESSAGE", "register", "failed");
    }
    
    return $this->app->redirDescriptor("MESSAGE", "register", "success");
  }
  /* === DEVELOPER END */
}