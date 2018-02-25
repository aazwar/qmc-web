<?php
namespace Model;
  
class Doctor extends \BaseModel {
  function __construct() {
    parent::__construct(\Fuwafuwa\Db::connection(), 'doctor');
    $this->keys = 'id';
    
    $this->beforeinsert(function($self) {
      $newId = FSQL1('SELECT COALESCE(MAX(id),0) + 1 FROM doctor');
      $self['id'] = $newId;
      $self['update_date'] = date('Y-m-d H:i:s');
    });
    
    $this->beforeupdate(function($self) {
      $self['update_date'] = date('Y-m-d H:i:s');
    });
  }
  
}