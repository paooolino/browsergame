<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Attiva l'utente e redirige al profilo.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace UserDemo\Controller;

class Register_confirm_actionController {
  private $router;
  private $app;
  
  public function __construct($router, $app) {
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
  private function doAction($request, $response, $args) {
    // create your action here.
    die("please create the action by editing the /src/Controller/Register_confirm_actionController.php file");
    return [
      "status" => "success"
    ];
  }
  /* === DEVELOPER END */
}