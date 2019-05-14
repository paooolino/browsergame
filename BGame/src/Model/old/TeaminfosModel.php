<?php
namespace BGame\Model;

class TeaminfosModel {
  private $db;
    
  
  public function __construct($db) {
    $this->db = $db;
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  public function get($args) {
    // retrieve and return requested data here
    $team = $this->db->query("SELECT * FROM teams WHERE id = ?", [$args['id']]);
    $team[0]["players"] = $this->db->query("SELECT *, teams.name as team FROM players LEFT JOIN teams ON players.id_team = teams.id WHERE id_team = ?", [$args['id']]);
    return $team[0];
  }  
  /* === DO NOT REMOVE THIS COMMENT */
}