<?php
namespace Ajax\Tabel;

class User extends \Fuwafuwa\AjaxController {
  function list() {
    record_list('user', 'login,fullname,role');
  }
  
  function setpass() {
    extract($this->request); // login, pass
    $hash = password_hash($pass, PASSWORD_BCRYPT);
    SQL('UPDATE user SET password = ? WHERE login = ?', $hash, $login);
  }  
}
?>