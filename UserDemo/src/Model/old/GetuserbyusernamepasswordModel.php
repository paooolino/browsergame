<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Please add a [desc] attribute to the getUserByUsernamePassword model.
 *
 *  @status 1 
 */
/* === DEVELOPER END */
namespace UserDemo\Model;

class GetuserbyusernamepasswordModel {
  private $db;
    
  
  public function __construct($db) {
    $this->db = $db;
  }
  
  /* === DEVELOPER BEGIN */
  public function get($request, $args) {
    $email = $request->getParsedBody()["email"];
    $password = $request->getParsedBody()["password"];
    
    $query = "SELECT * FROM users WHERE email = ?";
    $result = $this->db->query($query, [$email]);
    
    foreach ($result as $row) {
      if (password_verify($row["password"], PASSWORD_DEFAULT) == $password) {
        return [
          "email" => $row["email"]
        ];
      }
    }
    
    return [];
  }  
  /* === DEVELOPER END */
}