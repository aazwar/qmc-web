<?php

use \Fuwafuwa\FSQL;

/**
* HTML Utility
*/
class HtmlUtil {

  static function yearSelect($name="year", $start=2007) {
    $result = "<select name=\"$name\" id=\"$name\">\n";
     for($i=$start;$i < date("Y");$i++) {
       $result .= "  <option>$i</option>\n";
     }
     $result .= "  <option selected>" . date("Y") . "</option>\n";
     $result .= "</select>";
     return $result;
  }

  static function monthSelect($name="month", $withZero = false, $zeroText = "Semua", $width=60) {
    $result = "<select name=\"$name\" id=\"$name\" style=\"width: ${width}px\">\n";
    if($withZero) {
      $result .= "  <option value=\"0\">$zeroText</option>\n";
    }
    for($i=1;$i<=12;$i++) {
      $result .=  "  <option". ($i==date("m")?" selected":"") .">$i</option>\n";
    }
    $result .= "</select>\n";
    return $result;
  }
  
  static function select($table, $field, $default='', $code_field = 'code', $name_field = 'name') {
    new \Fuwafuwa\Db();
    $result = "<select name='$field' id='$field'>";
    $sql = "SELECT $code_field as cf, $name_field as nf FROM $table";
    $list = FSQL($sql);
    $result .= join("\n", array_map(function($e) { return "<option value='$e[0]'>$e[1]</option>"; }, $list));
    $result .= "</select>";
    return $result;
  }
  
  static function selectOption($table, $default='', $code_field = 'code', $name_field = 'name') {
    $cache = \Cache::instance();
    $key = "selectOption.$table";
		if($result = $cache->get($key)) {
			return $result;
		};    
    $sql = "SELECT $code_field as cf, $name_field as nf FROM $table";
    $list = FSQL($sql);
    if(!$default) {
      $list[] = ['',''];
    }
    $values = "{" . join(',',array_map(function($e) { return "'$e[0]':'$e[1]'"; }, $list)) ."}";
    $result = "{
      edittype: 'select',
      editoptions: {
        value: $values,
        defaultValue: '$default'
      },
      formatter: 'select'
    }";
    \Cache::instance()->set($key, $result, 3600*24); 
    return $result;
  }
  
  static function selectOption2($key, $default='') {
    $f3 = \Base::instance();
    $list = $f3["LOOKUP.$key"];
    if(!$default) {
      $list[''] = '';
    }
    $values = "{" . join(',',array_map(function($k,$v) { return "'$k':'$v'"; }, array_keys($list), $list)) ."}";
    $result = "{
      edittype: 'select',
      editoptions: {
        value: $values,
        defaultValue: '$default'
      },
      formatter: 'select'
    }";
    return $result;
  }
  
  static function radio($id, $value, $label, $defaultIndex=0) {
    $result = "<span id=\"$id\" class=\"button-set\">\n";
    for($i=0;$i<count($value);$i++) {
      $checked = $defaultIndex == $i ? "checked " : "";
      $result .= "<input type=\"radio\" id=\"$id$i\" name=\"$id\" ${checked}value=\"$value[$i]\">
  		  <label for=\"$id$i\">$label[$i]</label>\n";
    }
    $result .= "</span>\n";
    return $result;
  }
   
  static function termRadio() {
    return self::radio('term', ['harian', 'mingguan', 'bulanan'], ['Harian', 'Mingguan', 'Bulanan']);
  }
  
  static function longtermRadio() {
    return self::radio('term', ['harian', 'mingguan', 'bulanan', 'trimester', 'semester', 'tahunan'], 
      ['Harian', 'Mingguan', 'Bulanan', 'Trimester', 'Semester', 'Tahunan']);
  }
  
  static function sourceRadio() {
    return self::radio('source', ['kasir', 'komputer', 'belakang', 'all'], ['Kasir', 'Komputer', 'Belakang', 'All'], 1);
  }    
  static function datePicker($id="tanggal") {
    return "<span class=\"input-group-addon\"><i class=\"fa fa-calendar fa-fw\"></i></span>
      <input id=\"$id\" style=\"width: 75px\" class=\"date-picker\">";
  }
  
  static function grid($gridId="list", $pagerId="pager") {
    return "<table id=\"$gridId\" width=\"100%\"><tr><td></td></tr></table><div id=\"$pagerId\"></div>";
  }
}

?>