<?php
namespace Model;
  
class History extends \BaseModel {
  function __construct() {
    parent::__construct(\Fuwafuwa\Db::connection(), 'case_history');
    $this->keys = ['id','category'];        
  }  
}