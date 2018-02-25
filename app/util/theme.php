<?php
  
class Theme {
	static function printSubmenu($menu,$level, $group) {
    $base = \Base::instance()->get('BASE');
		if($level == 1) {
			$result .= "<ul id='main-menu' class='sm sm-clean'>\n";
		} else {
			$result .=  "<ul>\n";
		}
		foreach($menu as $sm) {
			if($sm['enabled']) {
				if($sm['submenu']) {
					$result .=  "  <li><a href='#'><span>$sm[title]</span></a>\n";
					$result .= self::printSubmenu($sm['submenu'],$level+1, $group);
					$result .=  "  </li>";
				} else {
					$result .=  "  <li><a href='$base/$sm[url]'>$sm[title]</a></li>\n";
				}
			}
		}
		$result .=  "</ul>\n";
    return $result;
	}
  
  private static function getTemplateBase() {
    $f3 = Base::instance();
    return $f3['APP.theme'] ? "_themes/". $f3['APP.theme']. "/" : "";
  }
  
  static function getTemplateMain() {
    return self::getTemplateBase() . "template.htm";
  }
  
  static function getTemplateFile($template) {
    $base = \Base::instance()->get('ROOT');
    $file = self::getTemplateBase() . $template;
    //print "$base/app/views/$file"; die();        
    if(file_exists("$base/app/views/$file")) return $file;
    return $template;
  }
}

?>