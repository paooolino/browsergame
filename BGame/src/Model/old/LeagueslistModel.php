<?php
namespace BGame\Model;

class LeagueslistModel {
  private $db;
    
  
  public function __construct($db) {
    $this->db = $db;
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  public function get() {
    return $this->db->query('SELECT * FROM leagues', []);
  }  
  /* === DO NOT REMOVE THIS COMMENT */
}