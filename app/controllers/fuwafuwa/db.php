<?php
// Warning is still considered valid data, the error message breaks json parser
//error_reporting(E_ERROR | E_PARSE);

namespace Fuwafuwa {

  class Db {
    static function connection() {
      $f3 = \Base::instance();
      if(!$f3['db']) {
        $f3['db'] = new \DB\SQL($f3['APP.dbconn'], $f3['APP.dbuser'], $f3['APP.dbpass']);
      }
      return $f3['db'];
    }
  }

}
namespace {
  include_once('sql.php');
  include_once('util.php');

  function SQL() {
    $db = Fuwafuwa\Db::connection();
    $params = func_get_args();
    if(is_array($params[0])) $params = $params[0];
    $query = array_shift($params);
    return $db->exec($query, $params);
  }

  function FSQL() {
    $params = func_get_args();
    if(is_array($params[0])) $params = $params[0];
    return array_map(function($e) { return array_values($e); }, SQL($params));
  }

  function FSQLC() {
    $params = func_get_args();
    if(is_array($params[0])) $params = $params[0];
    return array_map(function($e) { return $e[0]; }, FSQL($params));
  }

  function FSQLR() {
    $params = func_get_args();
    if(is_array($params[0])) $params = $params[0];
    return FSQL($params)[0];
  }

  function FSQL1() {
    return FSQLR(func_get_args())[0];
  }

  function SQLBI($sql, $values, $chunk_size=100) {
  	$fmt_values = array_map(function($row) {
  		$str_values = array_map(function($e) {
  			return "'" . escapeSQLString($e) ."'";
  		}, $row);
  		return '(' . join(', ', $str_values) . ')';
  	}, $values);
  	foreach(array_chunk($fmt_values, $chunk_size) as $chunk) {
  		$sql_exec = "$sql VALUES " . join(', ', $chunk);
  		SQL($sql_exec);
  	}
  }

  function SQLBU($sql, $pk, $values, $chunk_size=100) {
  	$fmt_values = array_map(function($e) {
  		return "'" . escapeSQLString($e) ."'";
  	}, $values);
  	foreach(array_chunk($fmt_values, $chunk_size) as $chunk) {
  		$sql_exec = "$sql WHERE $pk IN (" . join(', ', $chunk) . ")";
  		SQL($sql_exec);
  	}
  }  
}

?>
