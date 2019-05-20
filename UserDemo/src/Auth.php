<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Cambia la password dell'utente.
 *
 *  @status 1 
 */
/* === DEVELOPER END */
namespace UserDemo;

class Auth {
  private $db;
    
  public function __construct($db) {
    $this->db = $db;
  }
  
  /* === DEVELOPER BEGIN */
  
  public function register_user($email, $password) {
    $query = "INSERT INTO users (
      username,
      password
    ) VALUES (
      ?, ?
    )";
    $result = $this->db->query($query, [$email, $password]);
    return $result;
  }
  
  /* === DEVELOPER END */
}