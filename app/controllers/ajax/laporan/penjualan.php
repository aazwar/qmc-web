<?php
  
namespace Ajax\Laporan;

class Penjualan extends \Fuwafuwa\AjaxController {
  function detail() {
    print file_get_contents('app/json/penjualan.json');
  }
  
  function summary() {
    print file_get_contents('app/json/penjualan-summary.json');
  }
  
  function dashboard() {
    print file_get_contents('app/json/dashboard.json');
  }
  
	function pernota() {
    extract($this->request); // tanggal. nofaktur
		$sql = "SELECT tanggal, TIME(waktu), COALESCE(nama, '-- Non member --'),
			nofaktur, jumjual, poin, j.login
			FROM jual j
			LEFT JOIN customer c ON c.kode = j.kodecust
			ORDER BY waktu";
		$res = FSQL($sql);
		array2json($res, 3);
	}
	
	function detail_nota() {
    extract($this->request); // nofaktur
		$sql = "SELECT jd.kodebrg, COALESCE(b.nama_panjang,b.namabrg), jumlah, 
				jd.hgsatuan, subpot, jumlah*jd.hgsatuan-subpot
				FROM jual j
				JOIN jualdetail jd ON j.nofaktur = jd.nofaktur
				JOIN barang b ON b.kodebrg = jd.kodebrg
				WHERE j.nofaktur = ?";
		$res = FSQL($sql, $nofaktur);
		array2json($res);
	}
	
  
}
?>