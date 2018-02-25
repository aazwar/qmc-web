<?php
class BaseModel extends \DB\SQL\Mapper {  

  protected $keys; // primary keys, comma separated without space
  public function saveFromRequest() {
    $this->copyfrom('REQUEST');
    $this->save();
  }
  
  public function retrieve($key_values) {
    $cond = join(" AND ", array_map(function($e) { return "$e = ?";}, \Base::instance()->split($this->keys)));
    if(!is_array($key_values)) $key_values = [$key_values];
    $this->load(array_merge([$cond], $key_values));
  }
  
  public static function instance($key_values) {
    $record = new static();
    $record->retrieve($key_values);
    return $record;
  }
}
  
?>