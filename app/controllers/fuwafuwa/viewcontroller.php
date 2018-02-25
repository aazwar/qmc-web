<?php

namespace Fuwafuwa;

class ViewController {
	function execute($f3) {
		$access = \Access::instance();
		if($access->authorize($f3['SESSION.group'])) {
			$view = strtolower($f3['PARAMS']['class'] . '/' . $f3['PARAMS']['*']);
			$viewPath = $f3['ROOT'].$f3['BASE']."/app/views/$view.htm";
			if(file_exists($viewPath)) {
				$title = (new Menu())->title($view);
				$f3['report_title'] = $title;
				$f3['content'] = "$view.htm";
			} else {
				$f3['report_title'] = '<font color="red">ERROR: View not found</font>';
				$f3['view_name'] = $view;
				$f3['content'] = \Theme::getTemplateFile("view-not-found.htm");
			}
      if(!$title) {
        $title = ucwords(str_replace('-', ' ', basename($view)));
        $title = preg_replace_callback('/\b(\w{1,3})\b/', function ($matches) {
                    return strtoupper($matches[0]);
                }, $title);
        $f3['report_title'] = $title;
      }
			$f3['header_title'] = $f3->clean($f3['report_title']);
			echo \Template::instance()->render(\Theme::getTemplateFile('template.htm'));		
		}
	}	
}

?>