<?php
  
namespace Graphics;

class Charts extends \Fuwafuwa\Controller {
	function execute($f3, $action) {
    if(method_exists($this, $action)) {
			$this->request = $f3->get('REQUEST');
			$this->$action($f3);
    } else {
      die("Method doesn't exist: " . __CLASS__ . "\\$action");
    }
	}
  
  function line($f3) {
    $f3['title'] = 'Test';
    $f3['subtitle'] = 'XXX';
    $f3['content'] = 'grafik/chart/line.htm';
    echo \Template::instance()->render('bare.htm');		    
  }
}
?>