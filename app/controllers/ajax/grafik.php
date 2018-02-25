<?php
namespace Ajax;

class Grafik extends \Fuwafuwa\AjaxController {
  function belanja() {
    print file_get_contents('app/json/rerata-belanja.json');
  }
  
  function pelanggan1() {
    print file_get_contents('app/json/pelanggan1.json');
  }

  function pelanggan2() {
    print file_get_contents('app/json/pelanggan2.json');
  }
  
  function pola_belanja() {
    print file_get_contents('app/json/pola-belanja.json');
  }
  
  function rerata_sales_pertanggal() {
    print file_get_contents('app/json/rerata-sales.json');
  }
}  
  
?>