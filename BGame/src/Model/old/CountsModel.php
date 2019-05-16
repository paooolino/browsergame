<?php
namespace BGame\Model;

class CountsModel {
  private $db;
    
  
  public function __construct($db) {
    $this->db = $db;
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  public function get($args) {
    // retrieve and return requested data here
    $playerscount = $this->db->query("SELECT count(*) AS counter FROM players", []);
    $teamscount = $this->db->query("SELECT count(*) AS counter FROM teams", []);
    return [
      "players" => $playerscount[0]["counter"],
      "teams" => $teamscount[0]["counter"]
    ];
  }  
  /* === DO NOT REMOVE THIS COMMENT */
}