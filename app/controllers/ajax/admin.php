<?php

namespace Ajax;

class Admin extends \Fuwafuwa\AjaxController {	
	function clear_cache() {
		\Cache::instance()->clear('CACHE');
	}
	
	private function execute_script($params) {
		$root = "D:\\AppServ\\www";
		$perl = "$root\\aggregate.pl";
		$par = is_array($params)?join(" ", $params):$params;
		$cmd = "$perl $par";
		exec("$cmd", $out, $ret);
		print(join("<br>", $out));
		print("<br><br>--- Selesai ---");
	}

	function aggregate_daily() {
		$tanggal = $this->param('tanggal');
		$this->execute_script($tanggal);
	}

	function aggregate_monthly() {
		$tanggal = $this->param('tanggal');
		$ym = substr($tanggal, 0, 7);
		$this->execute_script(['monthly', $ym]);
	}

	function fix_jenis_aggregate() {
		$tanggal = $this->param('tanggal');
		$ym = substr($tanggal, 0, 7);
		$this->execute_script(['fix-jenis-aggregate', $ym]);
	}

	function update_jurnal() {
		$tanggal = $this->param('tanggal');
		$ym = substr($tanggal, 0, 7);
		$this->execute_script(['update-jurnal', $ym]);
	}

	function update_jurnal_tahunan() {
		$tanggal = $this->param('tanggal');
		$year = substr($tanggal, 0, 4);
		$this->execute_script(['update-jurnal-tahunan', $year]);
	}

	function redo_purchase() {
		$tanggal = $this->param('tanggal');
		$ym = substr($tanggal, 0, 7);
		$this->execute_script(['redo-purchase',$ym]);
	}

	function fix_stok_sales_data() {
		$this->execute_script('fix-stok-sales-data');
	}

	function aggregate_yearly() {
	  $root = realpath(dirname(dirname(__FILE__)));
		$script = "$root\\aggregate.pl";
		$param = "test";
		exec("$script $param", $out, $ret);
		print_r($out);
	}

	function shutdown() {
		system('shutdown /s /t 0');
	}

	function check_aggregate_date() {
		$tanggal = $this->param('tanggal');
		$ym = date('Y-m', strtotime($tanggal));
		$sql = "SELECT DISTINCT RIGHT(tanggal,2) from jual_sum 
			WHERE tanggal BETWEEN '$ym-01' AND '$ym-31'";
		$dates = FSQLC($sql);
		print "$ym<br>";
		foreach(array_chunk($dates, 10) as $arr) {
			print(join(", ", $arr));
			print("<br>");
		}
	}
  
  function import_purchase_data() {
    $tanggal = $this->param('tanggal');
    $start = date('Y-m-01', strtotime($tanggal));
    $end = date('Y-m-t', strtotime($tanggal));
    $sql = "REPLACE INTO item_supplier_purchase (kodebrg, kodesup, beli, pembelian)
      SELECT kodebrg, kodesup, SUM(jumlah), SUM(pembelian) 
  		FROM beli_sum
  		WHERE kodesup = 'E030' AND tanggal BETWEEN '$start' AND '$end'
  		GROUP BY kodebrg";
    SQL($sql);
    print "Updated";
  }
}

?>