<?php

namespace Fuwafuwa {

  class Controller {
  	protected $params;
	
  	protected function param($name, $default=Null) {
  		return $this->request[$name] ?: $default;
  	}
	
  	protected function set_param($name, $value) {
  		\Base::instance()->set("REQUEST.$name", $value);
  	}
	
  	protected function safe_key($key) {
  		return str_replace("-", "_", \Web::instance()->slug($key));
  	}
  
    protected function request() {
      return $this->request;
    }
	
  	function execute($f3, $action) {
      if(method_exists($this, $action)) {
        $this->request = $f3['REQUEST'];
  			$this->$action();
      } else {
        die(t('METHOD_TIDAK_ADA', __CLASS__ . "\\$action"));
      }
  	}
  }

}

// Translation
namespace {
  function t() {
    $f3 = \Base::instance();
    $args = func_get_args();
    if($f3['PREFIX']) {
      $args[0] = $f3['PREFIX'] . $args[0];
    }
    return call_user_func_array([$f3, 'get'], $args);
  }
}

?>
