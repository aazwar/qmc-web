<?php
namespace Model;
  
class Video extends \BaseModel {
  function __construct() {
    parent::__construct(\Fuwafuwa\Db::connection(), 'video');
    $this->keys = 'id';        
  }  
}