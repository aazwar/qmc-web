<?php
namespace Ajax\Tabel;

class Department extends \Fuwafuwa\AjaxController {
	function list1() {
		record_list('department', ["id", "name_en", "name_ar", "update_date"]);
	}

	function edit() {
    parent::ajaxEdit('\Model\Department', 'id');
	}
}