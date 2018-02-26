<?php
namespace Ajax\Tabel;

class History extends \Fuwafuwa\AjaxController {
	function list1() {
		record_list2(
      'case_history h JOIN case_category c ON h.category = c.id', 
      ["h.id", "name", "before_image", "before_caption", "after_image", "after_caption"],
      [],
      [],
      "SELECT COUNT(1) FROM case_history"
    );
	}

	function edit() {
    parent::ajaxEdit('\Model\history', 'id');
	}
}