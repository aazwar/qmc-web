<?php
namespace Ajax\Tabel;

class Doctor extends \Fuwafuwa\AjaxController {
	function list1() {
		record_list('doctor', ["id", "photo", "name_en", "name_ar", "title_en", "title_ar", "biography_en", "biography_ar", "update_date"]);
	}

	function edit() {
    parent::ajaxEdit('\Model\Doctor', 'id');
	}
}