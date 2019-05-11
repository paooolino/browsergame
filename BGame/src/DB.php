<?php
namespace BGame;

class DB {
  
  private $conn;
  
  public function __construct() {
    //
  }
  
  public function setupMysql($host, $user, $pass, $dbname) {
    try {
      $this->_conn = new PDO(
        'mysql:host=' . $db_host . ';dbname=' . $db_name, 
        $db_user, 
        $db_pass,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
      );
      return $this->_conn;
    } catch (PDOException $e) {
      die("db connection error");
    }
  }
  
}