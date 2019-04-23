<?php
namespace BGame\Controller;   
  
class BaseController {
  protected $view;
  protected $templatePath;
  
  public function __construct($view) {
    $this->view = $view;
    $this->templatePath = "";
  }
}
