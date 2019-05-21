<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Dati in ingresso $domain e $type, ritorna $title e $message
 *
 *  @status 1
 */
/* === DEVELOPER END */
namespace UserDemo\Model;

class MessageModel {
    
  
  public function __construct() {
  }
  
  /* === DEVELOPER BEGIN */
  public function get($domain, $type) {
    return [
      "title" => $domain,
      "description" => $type
    ];
  }  
  /* === DEVELOPER END */
}