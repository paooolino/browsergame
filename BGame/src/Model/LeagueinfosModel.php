<?php
namespace BGame\Model;

class LeagueinfosModel {
  
  public function __construct() {
    //
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  public function get() {
    return [
      "name" => "Serie A",
      "standings" => [
        [
          "team" => "Juventus",
          "points" => "89",
          "played" => "35",
          "wins" => "28",
          "draws" => "5",
          "loss" => "2",
          "goals_scored" => "69",
          "goals_taken" => "25",
        ], [
          "team" => "Napoli",
          "points" => "73",
          "played" => "35",
          "wins" => "22",
          "draws" => "7",
          "loss" => "6",
          "goals_scored" => "31",
          "goals_taken" => "35",
        ],
      ]
    ];
  }  
  /* === DO NOT REMOVE THIS COMMENT */
}