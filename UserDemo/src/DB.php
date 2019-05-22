<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Gestione database
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace UserDemo;

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
  
  public function select($query, $data) {
    $sth = $this->_conn->prepare($query);
    $sth->execute($data);
    if (!$sth)
      return [];
    return $sth->fetchAll(\PDO::FETCH_ASSOC);
  }
  
  public function query($query, $data) {
    $sth = $this->_conn->prepare($query);
    $result = $sth->execute($data);
    return $result;
  } 
}