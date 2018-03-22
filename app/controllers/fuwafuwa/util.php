<?php

/**
 * Fungsi compare untuk mengurutkan array 
 *
 * @return function
 * @author Azrul Azwar
 */
function create_compare_function($indexes) {
	for($i=0;$i<count($indexes);$i++) {
		$idx = $indexes[$i];
		if($idx < 0) {
			$idx = -$idx;
			$op = '>';
		} else {
			$op = '<';
		}
		$pre .= str_repeat(' ', $i) . 'if($a['.$idx.'] == $b['.$idx.']) {'."\n";
		if($i == count($indexes)-1) {
			$pre .= str_repeat(' ', $i+1) . "return 0;\n";
		}
		$suf = str_repeat(' ', $i) . '}' . "\n" . 
		  str_repeat(' ', $i) . 'return ($a['.$idx.']'.$op.'$b['.$idx.'])?-1:1;' . "\n$suf";
	}
	return create_function('$a, $b',"$pre$suf");
}

/**
 * Fungsi compare untuk mengurutkan array yang sudah dalam format jqGrid
 *
 * @return function
 * @author Azrul Azwar
 */
function create_compare_function_a($indexes) {
	// negative = reverse
	for($i=0;$i<count($indexes);$i++) {
		$idx = $indexes[$i];
		if($idx < 0) {
			$idx = -$idx;
			$op = '>';
		} else {
			$op = '<';
		}
		$pre .= str_repeat(' ', $i) . 'if($a[cell]['.$idx.'] == $b[cell]['.$idx.']) {'."\n";
		if($i == count($indexes)-1) {
			$pre .= str_repeat(' ', $i+1) . "return 0;\n";
		}
		$suf = str_repeat(' ', $i) . '}' . "\n" . 
		  str_repeat(' ', $i) . 'return ($a[cell]['.$idx.']'.$op.'$b[cell]['.$idx.'])?-1:1;' . "\n$suf";
	}
	return create_function('$a, $b',"$pre$suf");
}

/**
 * Untuk menampilkan tabel jqgrid sederhana
 *
 * @return void
 * @author Azrul Azwar
 */
function record_list($a80071f37, $i69fe4aec, $ab71a=[], $abf89b7a96f0=[]) {
  $i1 =  Base::instance();
	$i718 = $i1['REQUEST.page'];
	$caa9f = $i1['REQUEST.rows'];
	$a969 = $i1['REQUEST.sidx'];
	$a9a3 = $i1['REQUEST.sord'];

	if(!$caa9f) $caa9f = 50;
	if(!$i718) $i718 = 1;
	if(count($abf89b7a96f0) && $abf89b7a96f0[$a969]) {
		$a969 = $abf89b7a96f0[$a969];
	}
	
	$cf93e = $ab71a;
	if($i1['REQUEST._search']) {
		$i2c9885 = json_decode($i1['REQUEST.filters'], true);
		foreach((array)$i2c9885['rules'] as $e981) {
			$i8d7 = escapeSQLString($e981[data]);
			switch($e981['op']) {
				case "eq": $cf93e[] = "$e981[field] = '$i8d7'"; break;
				case "ne": $cf93e[] = "$e981[field] != '$i8d7'"; break;
				case "lt": $cf93e[] = "$e981[field] < '$i8d7'"; break;
				case "le": $cf93e[] = "$e981[field] <= '$i8d7'"; break;
				case "gt": $cf93e[] = "$e981[field] > '$i8d7'"; break;
				case "ge": $cf93e[] = "$e981[field] >= '$i8d7'"; break;
				case "in": $cf93e[] = "$e981[field] IN ($i8d7)"; break;
				case "ni": $cf93e[] = "$e981[field] NOT IN ($i8d7)"; break;
				case "bw": $cf93e[] = "$e981[field] LIKE '$i8d7%'"; break;
				case "bn": $cf93e[] = "$e981[field] NOT LIKE '$i8d7%'"; break;
				case "ew": $cf93e[] = "$e981[field] LIKE '%$i8d7'"; break;
				case "en": $cf93e[] = "$e981[field] NOT LIKE '%$i8d7'"; break;
				case "cn": $cf93e[] = "$e981[field] LIKE '%$i8d7%'"; break;
				case "nc": $cf93e[] = "$e981[field] NOT LIKE '%$i8d7%'"; break;
			}
		}
	}

	if(count($cf93e)) {
		$e265 = "WHERE " . join(" $i2c9885[groupOp] ", $cf93e);
	}

	$ac89ab233 = "SELECT count(1) FROM $a80071f37 $e265";
	$ee294 = FSQL1($ac89ab233);
	if($ee294) {
		$a0tal_pages = ceil($ee294/$caa9f);
	} else {
		$a0tal_pages = 0;
	}
	if($i718 > $a0tal_pages) $i718 = $a0tal_pages;
	$aea2b = $caa9f*$i718 - $caa9f; // do not put $caa9f*($i718 - 1)
	if($aea2b < 0) $aea2b = 0;
	$i06e3s = is_array($i69fe4aec) ? join(", ", $i69fe4aec) : $i69fe4aec;
  if($a969) {
    $a70a1 = "ORDER BY $a969 $a9a3";
  }
	$a5c07930f0 = "SELECT $i06e3s
	  FROM $a80071f37
		$e265
	  $a70a1 LIMIT $aea2b, $caa9f";
	//print "<pre>$a5c07930f0</pre>"; die();
	$eb4a88 = FSQL($a5c07930f0);
	//print_r($eb4a88);
	array2json($eb4a88, 0, $ee294, $i718, $a0tal_pages);
}         

/**
 * menampilkan tabel jqgrid yang kompleks
 *
 * @return void
 * @author Azrul Azwar
 */
function record_list2($i127bbc83, $i69fe4aec, $ab71a=[], $abf89b7a96f0=[], 
	$abd172a9323b71="", $i627ecd91=0, $ic08f636f=false) {
  
  $i1 =  Base::instance();
	$i718 = $i1['REQUEST.page'];
	$caa9f = $i1['REQUEST.rows'];
	$a969 = $i1['REQUEST.sidx']; 
	$a9a3 = $i1['REQUEST.sord'];

	if(!$caa9f) $caa9f = 50;
	if(!$i718) $i718 = 1;
	if($abf89b7a96f0[$a969]) {
		$a969 = $abf89b7a96f0[$a969];
	}
	$cf93e = $ab71a;
	if($i1['REQUEST._search']) {
		$i2c9885 = json_decode($i1['REQUEST.filters'], true);
		foreach((array)$i2c9885['rules'] as $e981) {
			$i06e3 = $e981['field'];
			if($abf89b7a96f0[$i06e3]) {
				$i06e3 = $abf89b7a96f0[$i06e3];
			}
			$i8d7 = escapeSQLString($e981[data]);
			switch($e981['op']) {
				case "eq": $cf93e[] = "$i06e3 = '$i8d7'"; break;
				case "ne": $cf93e[] = "$i06e3 != '$i8d7'"; break;
				case "lt": $cf93e[] = "$i06e3 < '$i8d7'"; break;
				case "le": $cf93e[] = "$i06e3 <= '$i8d7'"; break;
				case "gt": $cf93e[] = "$i06e3 > '$i8d7'"; break;
				case "ge": $cf93e[] = "$i06e3 >= '$i8d7'"; break;
				case "in": $cf93e[] = "$i06e3 IN ($i8d7)"; break;
				case "ni": $cf93e[] = "$i06e3 NOT IN ($i8d7)"; break;
				case "bw": $cf93e[] = "$i06e3 LIKE '$i8d7%'"; break;
				case "bn": $cf93e[] = "$i06e3 NOT LIKE '$i8d7%'"; break;
				case "ew": $cf93e[] = "$i06e3 LIKE '%$i8d7'"; break;
				case "en": $cf93e[] = "$i06e3 NOT LIKE '%$i8d7'"; break;
				case "cn": $cf93e[] = "$i06e3 LIKE '%$i8d7%'"; break;
				case "nc": $cf93e[] = "$i06e3 NOT LIKE '%$i8d7%'"; break;
			}
		}
    $eaa = $i2c9885['groupOp'] ?: 'AND';
	} else {
    $eaa = 'AND';
  }

	if(count($cf93e)) {
		$e265 = "WHERE " . join(" $eaa ", $cf93e);
	}
	if($abd172a9323b71 && !$e265) {
		$ac89ab233 = $abd172a9323b71;
	} else {
		$ac89ab233 = "SELECT count(1) FROM $i127bbc83 $e265";
	}
	
	$ee294 = FSQL1($ac89ab233);	
	if($ee294) {
		$a0tal_pages = ceil($ee294/$caa9f);
	} else {
		$a0tal_pages = 0;
	}
	if($i718 > $a0tal_pages) $i718 = $a0tal_pages;
	$aea2b = $caa9f*$i718 - $caa9f; 
	if($aea2b < 0) $aea2b = 0;
	$i06e3s = is_array($i69fe4aec) ? join(", ", $i69fe4aec) : $i69fe4aec;
	$a5c07930f0 = "SELECT $i06e3s FROM $i127bbc83
		$e265
	  ORDER BY $a969 $a9a3 LIMIT $aea2b, $caa9f";
	$eb4a88 = FSQL($a5c07930f0);
	array2json($eb4a88, $i627ecd91, $ee294, $i718, $a0tal_pages);
}         

function jqgridWrap($rows, $count=0, $page=1, $total_pages=1) {
	if(!$count) $count = count($rows);
	$arr = array(
		"page" => $page,
		"total" => $total_pages,	
		"records" => $count,
		"rows" => $rows,
	);
	$result = json_encode($arr);
	print $result;
	return $result;
}

/**
 * konversi array biasa ke dalam format jqGrid
 *
 * @return string
 * @author Azrul Azwar
 */
function array2json($array, $id_index=0, $count=0, $page=1, $total_pages=1) {
	// format array to jqgrid json
	foreach((array)$array as $r) {
		$rows[] = array(
			'id' => $r[$id_index],
			'cell' => $r
		);
	};
	return jqgridWrap($rows, $count, $page, $total_pages);
}

/**
 * konversi array biasa ke dalam format jqGrid,
 * kolom pertama dihilangkan dari row, menjadi key
 *
 * @return string
 * @author Azrul Azwar
 */
function arrayh2json($array, $count=0, $page=1, $total_pages=1) {
	// format array to jqgrid json
	foreach((array)$array as $r) {
		$id = array_shift($r);
		$rows[] = array(
			'id' => $id,
			'cell' => $r
		);
	};
	return jqgridWrap($rows, $count);
}

/**
 * konversi array biasa ke dalam format jqGrid,
 * Array tidak mempunyai key, dibuatkan key nomor urut
 *
 * @return string
 * @author Azrul Azwar
 */
function arrayi2json($array, $count=0, $page=1, $total_pages=1) {
	// format array to jqgrid json
	$i=1;
	foreach((array)$array as $r) {
		$rows[] = array(
			'id' => $i++,
			'cell' => $r
		);
	};
	return jqgridWrap($rows, $count);
}

/**
 * Membuat list bulan dan tahun, digunakan untuk membuat query bulanan
 *
 * @return array
 * @author Azrul Azwar
 */
function monthList($year, $nyear=1, $withCurrent=false) {
  $cyear = date('Y');
  $month = date('m');
        
	if($cyear != $year) {
		$startYear = $year-$nyear+1;
		$startMonth = 1;
	} else {
		$startYear = $year-$nyear;
      if($withCurrent) {
        $month++;
        if($month>12) {
          $month = 1;
          $startYear++;
        }
      }
      $startMonth = $month;
    }
		
	for($i=0;$i<$nyear;$i++) {
		for($j=0;$j<12;$j++) {
			$runYear = $startYear + $i;
			$runMonth = $startMonth + $j;
			if($runMonth>12) {
				$runYear++;
				$runMonth -= 12;
			}
			$iterator[$i][] = [$runYear, $runMonth];
		}
	}
	if($nyear==1) return $iterator[0];
	else return $iterator;
}

/**
 * Membuat list interval bulan
 *
 * @return void
 * @author Azrul Azwar
 */
function monthIntervalList($year, $nyear=1, $withCurrent=false) {
	foreach(monthList($year, $nyear, $withCurrent) as $ym) {
		$start = sprintf('%04d-%02d-01', $ym[0], $ym[1]);
		$end = date('Y-m-t', strtotime($start));
		$result[] = [$start, $end];
	}
	return $result;
}

function sign($value) {
	if($value < 0) return -1;
	if($value > 0) return 1;
	return 0;
}

?>