<?php
namespace BGame;

class App {
  
  public $templateName;
  public $templateUrl; /* will be initiated by AppInit middleware */
  public $baseUrl;     /* will be initiated by AppInit middleware */
  
  public function __construct($templateName) {
    $this->templateName = $templateName;
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  
  // add your public functions here
  const AUTH_SALT = 'bpVM^|(sBA2O&Q+vIznnu0&t|(ka!=t*3zU3BcmGsGKOe>2f6x#j|`8~|Yfi.$Ra';
  
  public function userExists($username, $password) {
    if ($username == "admin" && $password == "admin") {
      return true;
    }
    return false;
  }
  
  public function setAuthCookie($username, $password) {
    setcookie('auth', '1', 0, '/');
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
}