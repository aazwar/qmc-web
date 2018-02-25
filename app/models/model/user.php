<?php

namespace Model;

class User extends \BaseModel {
  function __construct() {
    parent::__construct(\Fuwafuwa\Db::connection(), 'user');
    $this->keys = 'login';
  }
  
	public static function login($login, $pass) {
    $user = self::instance($login);
		if(!$user->dry()) {
		  if(password_verify($pass, $user->password)) return $user;
		};
	}
  
  
}
?>