<?php
namespace BGame2;

class DB {
  
  private $conn;
  
  public function __construct() {
    //
  }
  
  public function setupMysql($host, $user, $pass, $dbname) {
    try {
      $this->_conn = new \PDO(
        'mysql:host=' . $host . ';dbname=' . $dbname, 
        $user, 
        $pass,
        array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
      );
      return $this->_conn;
    } catch (\PDOException $e) {
      die("db connection error");
    }
  }
  
  public function query($query, $data) {
    $sth = $this->_conn->prepare($query);
    $sth->execute($data);
    return $sth->fetchAll(\PDO::FETCH_ASSOC);
  }
}