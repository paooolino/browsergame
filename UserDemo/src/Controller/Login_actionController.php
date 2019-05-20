<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Dati username e password in input, verifica se l'utente esiste nel database ed in caso positivo setta il cookie di login.
 *
 *  @status 1
 */
/* === DEVELOPER END */
namespace UserDemo\Controller;

class Login_actionController {
  private $auth;
  private $User_by_username_passwordModel;
  private $router;
  private $app;
  
  public function __construct($auth, $User_by_username_passwordModel, $router, $app) {
    $this->auth = $auth;
    $this->User_by_username_passwordModel = $User_by_username_passwordModel;
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
    
    $user = $this->User_by_username_passwordModel->get($email, $password);
    if (count($user) != 1) {
      return $this->app->redirDescriptor("MESSAGE", "login", "err");
    }
    
    $this->auth->create_user_session($user);
    return [
      "route_to" => "PROFILE"
    ];
  }
  /* === DEVELOPER END */
}