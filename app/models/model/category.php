<?php
namespace Model;
  
class Category extends \BaseModel {
  function __construct() {
    parent::__construct(\Fuwafuwa\Db::connection(), 'case_category');
    $this->keys = 'id';    
    
    $this->beforeinsert(function($self) {
      $self['id'] = FSQL1('SELECT MAX(id) FROM case_category')+1;
    });        
  }
  
}