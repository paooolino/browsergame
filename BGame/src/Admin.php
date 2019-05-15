<?php
namespace BGame;

class Admin {
  private $db;
    
  public function __construct($db) {
    $this->db = $db;
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  
  // add your public functions here
  public function createPlayer($opts) {
    $query = "
      INSERT INTO players (
        name,
        surname,
        age,
        role,
        ability,
        form
      ) VALUES (
        ?, ?, ?, ?, ?, ?
      )
    ";
    $data = [
      $opts["name"],
      $opts["surname"],
      $opts["age"],
      $opts["role"],
      $opts["ability"],
      $opts["form"]
    ];
    return $this->db->query($query, $data);
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
}