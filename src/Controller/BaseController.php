<?php
namespace BGame\Controller;   
  
class BaseController {
  protected $view;
  
  public function __construct($view, $app) {
    $this->view = $view;
    $this->templatePath = $app->templatePath;
  }
}
