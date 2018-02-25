<?php
  
namespace Ajax\Laporan;

class User extends \Fuwafuwa\AjaxController {
  function list() {
    extract($this->request);
    $sql = "SELECT login, fullname, role, password FROM user";
		$res = FSQL($sql);
		arrayi2json($res);
  }
}
?>