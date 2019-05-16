<?php
namespace BGame\Model;

class AdminmenuitemsModel {
  private $router;
    
  
  public function __construct($router) {
    $this->router = $router;
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  public function get($args) {
    return [
      "Gestione database" => [
        [
          "label" => "Giocatori", 
          "url" => "/players"
        ],
        [
          "label" => "Squadre", 
          "url" => "/teams"
        ]
      ],
      "Strumenti" => [
        [
          "label" => "Crea giocatori", 
          "url" => $this->router->pathFor("ADMIN_CREATE_PLAYERS")
        ],
        [
          "label" => "Organizza partita", 
          "url" => $this->router->pathFor("ADMIN_SCHEDULE_MATCH")
        ],
        [
          "label" => "Organizza competizione", 
          "url" => $this->router->pathFor("ADMIN_SCHEDULE_COMPETITION")
        ]
      ]
    ];
  }  
  /* === DO NOT REMOVE THIS COMMENT */
}