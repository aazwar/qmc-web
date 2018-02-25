<?php

namespace Ajax;

class Maintenance extends \Fuwafuwa\AjaxController {
  function table_structure() {
    $tables = FSQLC('show tables');
    print "<pre>";
    print '$table_fields = [' . "\n";
    foreach($tables as $table) {
      $cols = FSQLC("SHOW COLUMNS FROM $table");
      print "'$table' => [" . join(",", array_map(function($e) { return "'$e'"; }, $cols)) . "],\n";
    }
    print "];";
    print "</pre>";
  }  
  
  function table_structure_sqlite() {
    $tables = FSQLC('select distinct tbl_name from sqlite_master');
    print "<pre>";
    print '$table_fields = [' . "\n";
    foreach($tables as $table) {
      $cols = FSQL("PRAGMA table_info($table)");
      print "'$table' => [" . join(",", array_map(function($e) { return "'$e[1]'"; }, $cols)) . "],\n";
    }
    print "];";
    print "</pre>";
  }  
  
}  
  
?>