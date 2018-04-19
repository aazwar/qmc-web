<?php
namespace Fuwafuwa;

class Home {
	function root($f3) {
		$title = 'Report Dashboard';
		if($f3['SESSION.username']) {
			$content = \Theme::getTemplateFile('front.htm');
		} else {
			$content = \Theme::getTemplateFile('login.htm');
		}
    $f3->mset(['header_title' => $title, 'report_title' => $title, 'content' => $content]);
		echo \Template::instance()->render(\Theme::getTemplateMain());
	}
	
  function dispatch($f3) {
  	$class = dirname($f3['PARAMS']['0']);
  	$class = str_replace(['/', '-'], ['\\', '_'], $class); 
  	//$class = ucwords($class, '\\');
  	$class = preg_replace_callback("/(\w+)/", function($m) { return ucfirst($m[1]); }, $class);
  	$action = basename($f3['PARAMS']['*']);
  	$action = str_replace('-', '_', $action);
  	if(class_exists($class)) { // Classes that extends \Fuwafuwa\AjaxController, or free class
  		(new $class())->execute($f3, $action);
  	} elseif($f3['PARAMS.class'] == 'ajax') { // Base Ajax class, can't find method, so display error
  		(new AjaxController())->execute($f3, $action);
    } else { // Controller that display html template
  		(new ViewController())->execute($f3); 
  	}    
  }
  
	function access_denied($f3) {
		$f3['report_title'] = '<font color="red">Access Denied<font>';
		$f3['content'] = \Theme::getTemplateFile('denied.htm');
		echo \Template::instance()->render('template.htm');
	}
	
	function login($f3) {
		if($f3['REQUEST.username']) {
			$loginInfo = \Model\User::login($f3['REQUEST.username'], $f3['REQUEST.password']);
      //print "<pre>"; print_r($loginInfo); die();
			if($loginInfo) {
				$f3['SESSION.username'] = $f3['REQUEST.username'];
				$f3['SESSION.fullname'] = $loginInfo['fullname'];
				$f3['SESSION.group'] = $loginInfo['role'];
				if($f3['REQUEST.url']) {
					$f3->reroute($f3['REQUEST.url']);
				} else {
					$f3->reroute('/');
				}
			} else {
				$content = 'login-failed.htm';
        $title = '<font color="red">Login failed!</font>';
        $f3->mset(['header_title' => $title, 'report_title' => $title, 'content' => $content]);
				echo \Template::instance()->render(\Theme::getTemplateMain());
				return;
			}
		} else {
      if($f3['SESSION.username']) {
        $f3->reroute('/');
      } else {
  			$content = \Theme::getTemplateFile('login.htm');
        $f3->mset(['header_title' => $title, 'report_title' => 'Report Dashboard', 'content' => $content]);
        echo \Template::instance()->render(\Theme::getTemplateMain());
      }
		}
	}

	function login_check($f3) {
    if($f3['SESSION.username']) {
      $f3['SESSION.username'] = $f3['SESSION.username'];
  		echo 1;      
    } else {
      echo 0;
    }
	}

	function logout($f3) {
    $f3->clear('SESSION');
		$f3->reroute('/');
	}
	
	function error($f3) {
    if($f3['AJAX']) {
  		echo \Template::instance()->render('error-ajax.htm');
    } else {
  		$title = 'ERROR ' . $f3['ERROR.code'];    
  		$f3['header_title'] = $title;
  		$f3['report_title'] = "<font color='red'>$title</font>";
  		$f3['content'] = 'error.htm';
  		echo \Template::instance()->render(\Theme::getTemplateMain());
    }
	}
	
	function info($f3) {
		print "<pre>";
		print_r($f3);
		print "</pre>";
	}
  
  function test($f3) {
    print \t('METHOD_TIDAK_ADA', 'xxxx');
  }
  
}
	
?>