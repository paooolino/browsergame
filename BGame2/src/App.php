<?php
namespace BGame2;

class App {
  
  public $templateName;
  public $templateUrl; /* will be initiated by AppInit middleware */
  public $baseUrl;     /* will be initiated by AppInit middleware */
  
  public function __construct($templateName) {
    $this->templateName = $templateName;
  }
  
  /* === DEVELOPER BEGIN */
  
  // add your public functions here
  
  /* === DEVELOPER END */
}