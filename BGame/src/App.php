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
  
  public function userExists($username, $password) {
    return false;
  }
  
  public function setAuthCookie() {
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
}