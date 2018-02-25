<?php

namespace Ajax;

class Reference extends \Fuwafuwa\AjaxController {
	function jenis_list() {
    print file_get_contents('app/json/jenis-list.json');
	}

	function common_jenis_list($level=3, $unsel_main=0, $unsel_sub=0, $include_old=0) {
		$key = "jenis_list.$level.m$unsel_main.s$unsel_sub.n$include_old";
    $this->retrieveCache($key, $reset);

		if(!$include_old) $cond = "WHERE LENGTH(kode) = 1";
		$sql = "SELECT kode, nama FROM kategori $cond ORDER BY kode";
		$main = FSQL($sql);
		foreach($main as $m) {
			if($level>1) {
				$sub = FSQL("SELECT kode, nama FROM kategori_sub WHERE kode_induk = ? ORDER BY kode_induk, kode", $m[0]);
				$children = [];
				foreach($sub as $s)	{
					if($level>2) {
						$ssub = SQL("SELECT j.kode as 'id', nama as 'text' FROM jenisbrg j 
							JOIN kategori_jenis k ON k.kode_jenis = j.kode
						  WHERE k.kode_induk = ? AND k.kode = ?", $m[0], $s[0]);
						$child = ['id' => "$m[0]$s[0]", 'text' => $s[1], 'children' => $ssub];
					} else {
						$child = ['id' => "$m[0]$s[0]", 'text' => $s[1]];
					}
					if($unsel_sub) unset($child['id']);
					$children[] = $child;
				}		
			}
		
			if($unsel_main) {
				$mentry = ['text' => $m[1]];
			} else {
				$mentry = ['id' => $m[0], 'text' => $m[1]];
			}
			if(count($children)) {
				$mentry['children'] = $children;
			}
			$kategori[] = $mentry;
		}
		$result = json_encode($kategori);
		\Cache::instance()->set($key, $result, 3600*24); // 1 day caching
		print $result;
	}

	function merk_list() {
    extract($this->request); // jenis
		$merk = SQL("SELECT kode as 'id', nama as 'text' FROM merkbrg WHERE jenis = ? ORDER BY nama", $jenis);
		print json_encode($merk);
	}

	function noperk_list() {
    extract($this->request); // with_aggregate
		$key = "noperk_list.$with_aggregate";
    $this->retrieveCache($key, $reset);

		$sql = "SELECT noperk as 'id', perkiraan as 'text' FROM ledger 
	    WHERE APDB IN(3,4) AND bapak = ?
	    ORDER BY noperk";
		$main = FSQL($sql, '');
		foreach($main as $m) {
			$sub = FSQL($sql, $m[0]);
			$children = [];
			foreach($sub as $s)	{
	      $ssub = SQL($sql, $s[0]);
				$child = ['id' => $s[0], 'text' => $s[1]];
	      if($ssub) {
	        $child['children'] = $ssub;
	      }
				$children[] = $child;
			}		
		
			$mentry = ['id' => $m[0], 'text' => $m[1]];
	    if(count($children)) {
				$mentry['children'] = $children;
			}
			$lnoperk[] = $mentry;
		}
		if($with_aggregate) {
			$lnoperk[] = ['id' => 'AG1', 'text' => 'PENDAPATAN (AGGREGAT)', 
				'children' => [
					['id' => 'AG1.1', 'text' => 'PENJUALAN [A]'],
					['id' => 'AG1.2', 'text' => 'PDPT LAIN-LAIN [A]'],
					['id' => 'AG1.3', 'text' => 'HPP [A]'],
					['id' => 'AG1.4', 'text' => 'PENDAPATAN KOTOR [A]'],
					['id' => 'AG1.5', 'text' => 'PENDAPATAN BERSIH [A]'],
				]
			];
			$lnoperk[] = ['id' => 'AG2', 'text' => 'BIAYA (AGGREGAT)', 
				'children' => [
					['id' => 'AG2.1', 'text' => 'GAJI [A]'],
					['id' => 'AG2.2', 'text' => 'BUNGA [A]'],
					['id' => 'AG2.3', 'text' => 'GEDUNG [A]'],
					['id' => 'AG2.4', 'text' => 'PRIVÉ [A]'],
					['id' => 'AG2.5', 'text' => 'OPERASIONAL [A]'],
					['id' => 'AG2.6', 'text' => 'PAJAK/INFAK [A]'],
					['id' => 'AG2.7', 'text' => 'BIAYA LAIN-LAIN [A]'],
					['id' => 'AG2.8', 'text' => 'BIAYA TOTAL [A]'],
				]
			];
		}
		$result = json_encode($lnoperk);
		\Cache::instance()->set($key, $result, 3600*24); // 1 day caching
		print $result;
	}

	function dropdown_kelompok() {
    extract($this->request); // term
		$sql = "SELECT CONCAT(kel_id, ' | ', nama, ' | ', nama_filter) FROM kelompok k 
			JOIN jenisbrg j ON k.jenis = j.kode
			WHERE nama LIKE '%$term%' OR nama_filter LIKE '%$term%'
			ORDER BY jenis, nama_filter";
		$kelompok = FSQLC($sql);	
		print(json_encode($kelompok));
	}

	function jenis_text() {
    extract($this->request); // kodebrg
		$jenis = FSQL1('SELECT jenis FROM barang_shadow WHERE kodebrg = ?', $kodebrg);
		if(strlen($jenis) == 6) {
			preg_match('/^(\d)(\d\d)/', $jenis, $m);
			$result['jenis1'] = FSQL1('SELECT nama FROM kategori WHERE kode = ?', $m[1]);
			$result['jenis2'] = FSQL1('SELECT nama FROM kategori_sub WHERE 
				kode_induk = ? AND kode = ?', $m[1], $m[2]);
			$result['jenis3'] = FSQL1('SELECT nama FROM jenisbrg WHERE kode = ?', $jenis);
		} else {
			$jj = FSQLR('SELECT kode_induk, kode FROM kategori_jenis WHERE kode_jenis = ?', $jenis);
			$result['jenis1'] = FSQL1('SELECT nama FROM kategori WHERE kode = ?', $jj[0]);
			$result['jenis2'] = FSQL1('SELECT nama FROM kategori_sub WHERE 
				kode_induk = ? AND kode = ?', $jj[0], $jj[1]);
			$result['jenis3'] = FSQL1('SELECT nama FROM jenisbrg WHERE kode = ?', $jenis);
		}
		print json_encode($result);
	}

  function merk_add() {
    extract($this->request); // jenis, merk
  	$sql = "SELECT MAX(kode) FROM merkbrg WHERE length(kode) = 6";
  	$last_id = FSQL1($sql) + 1;
  	$id_str = sprintf("%06d", $last_id);
  	SQL("INSERT INTO merkbrg(kode, nama, jenis) VALUES(?,?,?)", $id_str, $merk, $jenis);
  	print "$id_str $jenis $merk";
  }

	function list_merk() {
    extract($this->request); // jenis, merk
	
		if($jenis) {
			$lcond[] = jenis_cond($jenis, 'm');
		}
		$lcond[] = 'length(m.jenis) = 6';
		if($merk) {
			$lcond[] = "m.nama LIKE '%$merk%'";
		}
		$cond = implode("\nAND ", $lcond);
		$sql = "SELECT k1.nama, k2.nama, jn.nama, m.kode, m.nama, COUNT(b.jenis)
			FROM merkbrg m
			JOIN kategori_jenis kj on kj.kode_jenis = m.jenis
			JOIN kategori k1 on kj.kode_induk = k1.kode
			JOIN kategori_sub k2 on kj.kode_induk = k2.kode_induk and kj.kode = k2.kode
			JOIN jenisbrg jn on m.jenis = jn.kode
			LEFT JOIN barang_shadow b ON b.jenis = m.jenis AND b.merk = m.kode
			WHERE $cond
			GROUP BY m.kode
			ORDER BY k1.kode, k2.kode, jn.kode, m.nama";
		$res = FSQL($sql);
		array2json($res, 3);
	}

	function merk_list_lookup() {
    extract($this->request); // term
		if(strlen($term) < 3) {
			$term = "$term%";
		} else {
			$term = "%$term%";
		}
		$merk = FSQLC("SELECT DISTINCT nama FROM merkbrg 
			WHERE length(kode) = 6 AND nama LIKE '$term'
			ORDER BY nama LIMIT 20");
		$result = json_encode($merk);
		print $result;
	}

	function barang_harga() {
		$sql = "SELECT hgsatuan, hgbeli FROM barang_shadow WHERE kodebrg = ?";
		$result = json_encode(FSQLR($sql, $this->param('kodebrg')));
		print $result;
	}

	function barang_info() {
		$sql = "SELECT namabrg, hgsatuan FROM barang WHERE kodebrg = ?";
		$result = json_encode(FSQLR($sql, $this->param('kodebrg')));
		print $result;
	}

	function barang_harga_margin() {
		$sql = "SELECT hgsatuan, hgbeli, margin FROM barang_shadow b
			LEFT JOIN suggested_margin sm ON sm.kdjenis = b.jenis
			WHERE b.kodebrg = ?";
		$result = json_encode(FSQLR($sql, $this->param('kodebrg')));
		print $result;
	}

	function lookup_barang() {
    extract($this->request); // term
		if($this->param('paket')) $cond = "AND paket=1";
		if(preg_match('/^\\d+/', $term)) {
			$sql = "SELECT CONCAT(kodebrg, ' | ', namabrg) 
				FROM barang
				WHERE kodebrg REGEXP ? $cond ORDER BY LENGTH(kodebrg) LIMIT 20";
			$rows = FSQLC($sql, "^$term");
		} else {
      $cond = fulltext_search_cond("$term*");
			$sql = "SELECT CONCAT(kodebrg, ' | ', COALESCE(nama_panjang,namabrg)) 
				FROM barang
				WHERE $cond ORDER BY namabrg LIMIT 20";
			$rows = FSQLC($sql);
		}
		$result = json_encode($rows);
		print $result;
	}

	function lookup_barang2() {
    extract($this->request); // term
		$sql = "SELECT CONCAT(kodebrg, ' | ', namabrg, ' | ', hgsatuan)
			FROM barang_shadow 
			WHERE [WHERE] LIMIT 20";
		if(preg_match('/^\\d+/', $term)) {
			$sql = str_replace('[WHERE]', 'kodebrg REGEXP ? ORDER BY LENGTH(kodebrg)', $sql);
			$rows = FSQLC($sql, "^$term");
		} else {
			$sql = str_replace('[WHERE]', 'namabrg REGEXP ? ORDER BY namabrg', $sql);
			$rows = FSQLC($sql, $term);
		}
		$result = json_encode($rows);
		print $result;
	}

	function member_lookup() {
    extract($this->request); // term
		if(preg_match('/^\\d+/', $term)) {
			$sql = "SELECT kode as 'value', nama as 'label' FROM customer WHERE kode LIKE '%$term%'";
		} else {
			$sql = "SELECT kode as 'value', nama as 'label' FROM customer WHERE nama LIKE '%$term%'";
		}
		$rows = SQL($sql);	
		$result = json_encode($rows);
		print $result;
	}

	function member_address() {
    extract($this->request); // kodecust
		$alamat = FSQL1("SELECT alamat FROM customer WHERE kode = ?", $kodecust);
		print $alamat;
	}

	function lookup_jenis_barang() {
    extract($this->request); // kodebrg
		$sql = "SELECT b.jenis, j.nama FROM barang_shadow b
			JOIN jenisbrg j ON b.jenis = j.kode
			WHERE b.kodebrg = ?";
		$result = FSQLR($sql, $kodebrg);
		print(json_encode($result));
	}

	function supplier_merk() {
    extract($this->request); // supplier
		$key = "supplier_merk.$supplier";
    $this->retrieveCache($key, $reset);

		$merk = SQL("SELECT distinct m.nama as 'id', m.nama as 'text' 
		  FROM item_supplier_purchase isp
		  JOIN barang_shadow b ON isp.kodebrg = b.kodebrg
		  JOIN merkbrg m on m.kode = b.merk
		  WHERE isp.kodesup = ?
		  ORDER BY m.nama", $supplier);
		if(!$merk) $merk = [];
		if(!in_array('~Lain-lain', array_keys($merk))) {
			array_unshift($merk, ['id' => '~Lain-lain', 'text' => '~Lain-lain']);
		}
		$result = json_encode($merk);
		\Cache::instance()->set($key, $result, 3600*24*7);
		print $result;
	}
	
	function supplier_list2() {
    extract($this->request); // term
		if(strlen($term) < 3) {
			$term = "$term%";
		} else {
			$term = "%$term%";
		}
		$sql = "SELECT kode as 'value', nama as 'label' FROM supplier WHERE nama LIKE ?";
		$rows = SQL($sql, $term);	
		$result = json_encode($rows);
		print $result;
	}
	
	function supplier_list3() {
    extract($this->request); // term	
		if(preg_match('/[A-z]\d+/', $term)) {
			$field = 'kode';
			$term = "$term%";
		} else {
			if(strlen($term) < 3) {
				$term = "$term%";
			} else {
				$term = "%$term%";
			}
			$field = 'nama';
		}
		$sql = "SELECT CONCAT(kode, ' | ', nama) as value FROM supplier WHERE $field LIKE ?";
		$rows = SQL($sql, $term);	
		$result = json_encode($rows);
		print $result;
	}

	function supplier_name() {
    extract($this->request); // kode
		$sql = "SELECT nama FROM supplier WHERE kode = ?";
		$name = FSQL1($sql, $kode);	
		print $name;
	}

	function suggested_margin_lookup() {
    extract($this->request); // jenis
	  $sql = "SELECT margin FROM suggested_margin WHERE kdjenis = ?";
	  print(json_encode(FSQL1($sql, $jenis)));
	}

	function new_id() {
    extract($this->request); // table, opt
		print generate_id($table, $opt);
	}
	
  function table_search() {
    extract($this->request); // table, fields, keyword, op
    $searchFields = explode(",", $this->param('searchFields'));
    
    if($op == "FTS") {
      $lcond[] = fulltext_search_cond($keyword, $fields);
    } else {
      if($op == "LIKE") $keyword = "%$keyword%";
      foreach($searchFields as $sf) {
        $lcond[] = "$sf $op '$keyword'";
      }      
    }
    $cond = implode(" OR ", $lcond);
    $sql = "SELECT $fields FROM $table WHERE $cond LIMIT 30";
    print "<pre>$sql"; die();
    array2json(FSQL($sql));
  }
}

?>