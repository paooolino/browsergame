<?php
/* === DEVELOPER BEGIN */
  public function get($args) {
    // retrieve and return requested data here
  }  
  /* === DEVELOPER END */
namespace BGame\Model;

class PlayerModel {
  private $db;
    
  
  public function __construct($db) {
    $this->db = $db;
  }
  
  {{DEVELOPER_CODE}}
}