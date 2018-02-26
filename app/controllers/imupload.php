<?php

use \Fuwafuwa\FSQL1;
  
class Imupload {
	function execute($f3, $action) {
		$access = \Access::instance();
    if(method_exists($this, $action)) {
  		if($access->authorize($f3['SESSION.group'])) {
  			$this->$action();
  		} else {
  			$f3->error(403);
  		}
    } else {
      die("Method doesn't exist: " . __CLASS__ . "\\$action");
    }
	}
  
  function gallery() {
    new \Fuwafuwa\Db();
    $f3 = \Base::instance();
    $overwrite = true; // set to true, to overwrite an existing file; Default: false
    $slug = false; // rename file to filesystem-friendly version
    $web = \Web::instance();
    $files = $web->receive(function($file,$formFieldName){
          return true; // allows the file to be moved from php tmp dir to your defined upload dir
        },
        $overwrite,
        $slug
    );
    $id = FSQL1('SELECT MAX(id) FROM case_history')+1;
    $name1 = "case-b-$id.jpg";
    $name2 = "case-a-$id.jpg";
    $fnames = array_keys($files);
    rename($fnames[0], $f3['ROOT'].$f3['BASE']."/images/case_history/$name1");
    rename($fnames[1], $f3['ROOT'].$f3['BASE']."/images/case_history/$name2");
    $sql = "INSERT INTO case_history VALUES(?, ?, ?, ?, ?, ?)";
    SQL($sql, $id, $f3['REQUEST.category'], $name1, $f3['REQUEST.before_caption'], $name2, $f3['REQUEST.after_caption']);
    $f3['content'] = "case-history/receive.htm";
    echo \Template::instance()->render('template.htm');		
  }
  
}
?>