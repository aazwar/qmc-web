<?php
namespace Ajax\Tabel;

class Category extends \Fuwafuwa\AjaxController {
	function list1() {
		record_list('case_category', ["id", "name", "cover_image" ]);
	}

	function edit() {
    parent::ajaxEdit('\Model\category', 'id');
	}
}