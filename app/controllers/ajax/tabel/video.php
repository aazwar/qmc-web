<?php
namespace Ajax\Tabel;

class Video extends \Fuwafuwa\AjaxController {
	function list1() {
		record_list('video', 'id,date,caption,id as vid');
	}

	function edit() {
    parent::ajaxEdit('\Model\video', 'id');
	}
}