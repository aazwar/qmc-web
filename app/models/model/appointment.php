<?php
namespace Model;
  
class Appointment extends \BaseModel {
  function __construct() {
    parent::__construct(\Fuwafuwa\Db::connection(), 'appointment');
    $this->keys = 'id';
    
    $this->beforeinsert(function($self) {
      $self['id'] = date('ymd', strtotime($self['date'])) . sprintf('%02d', $self['hour']) . "-" . $self['slot'] . $self['department_id'];
    });    
  }
  
}