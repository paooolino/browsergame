<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Ritorna la lista degli utenti salvati nel db
 *
 *  @status 1
 */
/* === DEVELOPER END */
namespace UserDemo\Model;

class UserslistModel {
  private $db;
    
  
  public function __construct($db) {
    $this->db = $db;
  }
  
  /* === DEVELOPER BEGIN */
  public function get() {
    $query = "SELECT * FROM users";
    return $this->db->select($query, []);
  }  
  /* === DEVELOPER END */
}