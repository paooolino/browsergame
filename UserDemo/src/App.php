<?php
namespace UserDemo;

class App {
  
  public $templateName;
  public $templateUrl; /* will be initiated by AppInit middleware */
  public $baseUrl;     /* will be initiated by AppInit middleware */
  
  public function __construct($templateName) {
    $this->templateName = $templateName;
  }
  
  /* === DEVELOPER BEGIN */
  
  // ritorna un descrittore di redirect, utile per le action
  public function redirDescriptor($route, $domain, $type) {
    return [
      "route_to" => $route,
      "qs" => [
        "domain" => $domain,
        "type" => $type
      ]
    ];
  }
  
  /* === DEVELOPER END */
}