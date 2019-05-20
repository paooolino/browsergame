<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Dati username e password, ritorna il record del database corrispondente all'utente.
 *
 *  @status 1
 */
/* === DEVELOPER END */
namespace UserDemo\Model;

class User_by_username_passwordModel {
  private $db;
    
  
  public function __construct($db) {
    $this->db = $db;
  }
  
  /* === DEVELOPER BEGIN */
  public function get($email, $password) {
    $query = "SELECT * FROM users WHERE email = ?";
    $result = $this->db->select($query, [$email]);
    
    $authorized = [];
    foreach ($result as $row) {
      if (password_verify($password, $row["password"])) {
        $authorized[] = $row;
        return $authorized;
      }
    }
    return $authorized;
  }  
  /* === DEVELOPER END */
}