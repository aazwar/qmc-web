<?php

use function \Fuwafuwa\SQL, \Fuwafuwa\FSQL, \Fuwafuwa\FSQL1, \Fuwafuwa\FSQLR, \Fuwafuwa\FSQLC, \Fuwafuwa\SQLBI, \Fuwafuwa\SQLBU;

/**
 *
 * @return escapped string
 * @author Azrul Azwar
 */
function escapeSQLString($str) {
	return preg_replace("/'/", "''",$str);
}

/**
 * Membuat kondisi SQL dari $kv dan $pk
 *
 * @return void
 * @author Azrul Azwar
 */
function array2cond($kvs, $pk=NULL) {
	if($pk) {
		foreach($pk as $k) {
			$ev = escapeSQLString($kvs[$k]);
			$lcond[] = "$k = '$ev'";
		}
	} else {
		foreach($kvs as $key => $value) {
			$ev = escapeSQLString($value);
			$lcond[] = "$key = '$ev'";
		}
	}
	return join(" AND ", $lcond);
}

/**
 * Mempersiapkan $kv untuk operasi update
 *
 * @return void
 * @author Azrul Azwar
 */
function array2setlist($kvs) {
	foreach($kvs as $key => $value) {
		$ev = escapeSQLString($value);
		$lcond[] = "$key = '$ev'";
	}
	return join(", ", $lcond);
}

function filterKv($table, $kv) {
  // generated by ajax/maintenance/table-structure
  $table_fields = [
    'adm' => ['nomor', 'tanggal', 'nominal', 'login', 'logine', 'waktu', 'istutup',],
    'users' => ['username', 'fullname', 'pass', 'groups',],
  ];
  $intersect = array_intersect(array_keys($kv), $table_fields[$table]);
  foreach($intersect as $field) {
    $result[$field] = $kv[$field];
  }
  return $result;
}

function sqlEdit($table, $kv, $pks) {
  $kv = filterKv($table, $kv);
	foreach($pks as $k) {
		$ckv[$k] = $kv[$k];
		unset($kv[$k]);
	}
	$cond = array2cond($ckv);
	$setlist = array2setlist($kv);
	return "UPDATE $table SET $setlist
		WHERE $cond";
}

function sqlAdd($table, $kv) {
  $kv = filterKv($table, $kv);
	$fields = join(", ", array_keys($kv));
	$values = array_values($kv);
	foreach($values as &$v) {
		$v = "'" . escapeSQLString($v) . "'";
	}
	$values = join(", ", $values);
	return "INSERT INTO $table ($fields) VALUES ($values)";
}

function sqlDel($table, $kv, $pk) {
	$cond = array2cond($kv, $pk);
	return "DELETE FROM $table WHERE $cond";
}

function isUnique($table, $kv, $pk) {
	$cond = array2cond($kv, $pk);
	return FSQL1("SELECT count(1) FROM $table WHERE $cond") == 0;
}

function oldRecord($table, $kv, $pk) {
	$cond = array2cond($kv, $pk);
	return FSQLR("SELECT * FROM $table WHERE $cond");
}
  
?>