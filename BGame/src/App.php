<?php
namespace BGame;

class App {
  
  public $baseUrl;
  public $templateName;
  public $templateUrl;
  
  public function __construct($templateName) {
    $this->templateName = $templateName;
  }
  
}