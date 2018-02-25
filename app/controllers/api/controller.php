<?php
namespace Api;
new \Fuwafuwa\Db(); // supaya autoload

class Controller extends \Controller {
  protected function retrieveCache($key, $reset) {
    $cache = \Cache::instance();
    $key = $this->safe_key($key);
		if($reset) $cache->clear($key);
		if($result = $cache->get($key)) {
			print $result;
			die(); // This is ajax, so no problem with unfinished html
		};    
  }
  
  function authenticate($token) {
    return FSQL1("SELECT id FROM subscriber WHERE token = ?", $token);
  }
  
	function execute($f3, $action) {
    list($method, $token) = explode(' ', $f3['HEADERS.Authorization'], 2);
    print "$method, $token\n";
    if($method == 'Bearer' && $userId = $this->authenticate($token)) {
      if(method_exists($this, $action)) {
        $this->params = $f3->get('REQUEST');
        $this->params['user_id'] = $userId;
        $this->$action();
      } else {
        die(t('METHOD_TIDAK_ADA', __CLASS__ . "\\$action"));
      }
    } else {
      print '{"error": "' . t('INVALID_TOKEN') . '"}';
    }
	}
}

?>