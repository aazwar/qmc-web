<?php
namespace Ajax\Tabel;

class Appointment extends \Fuwafuwa\AjaxController {
	function matrix() {
    $f3 = \Base::instance();    
    $date = $f3['REQUEST.date'];
    $matrix = [];
		for($i=8;$i<=22;$i++) {
      $id = sprintf('%02d', $i) . "-1";
		  $matrix[] = [$id,$i,"1",'','','','','','','','','',''];
      $id = sprintf('%02d', $i) . "-2";
		  $matrix[] = [$id,"","2",'','','','','','','','','',''];
		}
    $apps = FSQL('SELECT id, date, hour, slot, department_id, patient_name, patient_phone FROM appointment
      WHERE date = ?', $date);
    foreach($apps as $app) {
      if($app[5]) {
        $matrix[$app[2]-9+$app[3]][$app[4]+2] = $app[5];
      }
    }
    arrayh2json($matrix);
	}

	function matrix_edit() {
    $f3 = \Base::instance();
    $id = date('ymd', strtotime($f3['REQUEST.date'])) . sprintf('%02d', $f3['REQUEST.hour']) . "-" . $f3['REQUEST.slot'] . $f3['REQUEST.department_id'];
    $appointment = \Model\Appointment::instance($id);
    $appointment->saveFromRequest();
	}
}