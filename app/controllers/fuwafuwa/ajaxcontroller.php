<?php
namespace Fuwafuwa;

new Db(); // supaya autoload

class AjaxController extends Controller {
  protected function retrieveCache($key, $reset) {
    $cache = \Cache::instance();
    $key = $this->safe_key($key) . ".txt";
		if($reset) $cache->clear($key);
		if($result = $cache->get($key)) {
			print $result;
			die(); // This is ajax, so no problem with unfinished html
		};    
  }
  
	function execute($f3, $action) {
		$access = \Access::instance();
    if(method_exists($this, $action)) {
  		if($access->authorize($f3['SESSION.group'])) {
  			$this->request = $f3['REQUEST'];
  			$this->$action();
  		} else {
  			$f3->error(403);
  		}
    } else {
      die(t('METHOD_TIDAK_ADA', __CLASS__ . "\\$action"));
    }
	}
  
  /**
   * Generic ajax function for jqGrid add/edit/del
   *
   * @param string $class 
   * @param string $pk 
   * @return void
   * @author Azrul Azwar
   */
  function ajaxEdit($class, $pk, $del=true) {
    extract($this->request); // kode
    if(is_array($pk)) {
      foreach($pk as $k) {
        $keys[] = $$k;
      }
      $record = $class::instance($keys);
    } else {
      $record = $class::instance($$pk);
    }
		$result['success'] = true;
		$result['id'] = $$pk;
    switch ($oper) {
      case 'add':
        if(!$record->dry()) {
          $result['success'] = false;
          print_r($record);
          if(is_array($pk)) {
            foreach($pk as $k) {
              $keys[] = $$k;
            }
            $key = join(', ', $keys);
          } else {
            $key = $$pk;
          }
          $record['message'] = sprintf("Rekaman ganda pada tabel '%s' dengan key '%s'", $record->table(), $key);
        } else {
          $record->saveFromRequest();
        }
        break;
      case 'edit':
        $record->saveFromRequest();
        break;
      case 'del':
        if(!$del) {
          $result['success'] = false;
          $result['message'] = 'Operasi penghapusan tidak diperbolehkan';
        } else {
          $record->erase();
        }
        break;      
      default:
        # code...
        break;
    }
		print json_encode($result);    
  }
}

?>