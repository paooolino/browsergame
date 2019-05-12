<?php
namespace BGame\Model;

class LeagueslistModel {
  
  public function __construct() {
    //
  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  public function get() {
    return [
      [
        "name" => "Serie A",
        "url" => "serie-a"
      ],
      [
        "name" => "Serie B",
        "url" => "serie-b"
      ],
      [
        "name" => "Lega Pro",
        "url" => "lega-pro"
      ],
      [
        "name" => "Campionato Nazionale Dilettanti",
        "url" => "cnd"
      ]
    ];
  }  
  /* === DO NOT REMOVE THIS COMMENT */
}