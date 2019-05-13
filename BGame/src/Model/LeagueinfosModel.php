<?php
namespace BGame\Model;

class LeagueinfosModel {
  private $db;
    
  
  public function __construct($db) {
    $this->db = $db;
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  public function get($args) {
    // retrieve and return requested data here
    $league = $this->db->query("SELECT * FROM leagues WHERE url = ?", [$args['url']]);
    $league_id = $league[0]["id"];
    $league[0]["standings"] = $this->db->query("SELECT *, teams.name as team FROM standings LEFT JOIN teams ON standings.id_team = teams.id WHERE id_league = ?", [$league_id]);
    return $league[0];
  }  
  /* === DO NOT REMOVE THIS COMMENT */
}