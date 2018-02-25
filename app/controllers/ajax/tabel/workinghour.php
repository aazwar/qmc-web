<?php
namespace Ajax\Tabel;

class WorkingHour extends \Fuwafuwa\AjaxController {
	function matrix() {
    $matrix = [];
		for($i=6;$i<=23;$i++) {
		  $matrix[] = [$i,0,0,0,0,0,0,0];
		}
    $hours = FSQL('SELECT day, hour, value FROM work_hour');
    foreach($hours as $hour) {
      if($hour[2]) {
        $matrix[$hour[1]-6][$hour[0]] = 1;
      }
    }    
    array2json($matrix);
	}

	function matrix_edit() {
    $f3 = \Base::instance();
    if($f3['REQUEST.value']) {
      SQL('INSERT OR REPLACE INTO work_hour (day,hour,value) VALUES (?,?,1)', $f3['REQUEST.day'], $f3['REQUEST.hour']);
    } else {
      SQL('DELETE FROM work_hour WHERE day = ? AND hour = ?', $f3['REQUEST.day'], $f3['REQUEST.hour']);
    }
	}
}