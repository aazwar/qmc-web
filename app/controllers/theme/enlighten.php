<?php

namespace Theme;

class Enlighten extends \Theme {
  
	static function printSubmenu($menu,$level, $group) {
    $base = \Base::instance()->get('BASE');
		if($level == 1) {
			$result .= "<ul id='hornavmenu' class='nav navbar-nav'>\n";
		} else {
			$result .=  "<ul>\n";
		}
		foreach($menu as $sm) {
			if($sm['enabled']) {
				if($sm['submenu']) {
          if($level == 1) $class = ' class="parent"';
					$result .=  "  <li$class><a href='#'><span>$sm[title]</span></a>\n";
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
  
	static function printSubmenuMobile($menu,$level, $group) {
    $base = \Base::instance()->get('BASE');
		if($level == 1) {
			$result .= '<ul class="slicknav_nav slicknav_hidden" aria-hidden="true" role="menu" style="display: none;">' . "\n";
      $result .= '<li><a href="' . "$base/" . '" class="fa-home" role="menuitem" tabindex="-1">Home</a></li>';
		} else {
			$result .=  "<ul>\n";
		}
		foreach($menu as $sm) {
			if($sm['enabled']) {
				if($sm['submenu']) {
          if($level == 1) $class = ' class="slicknav_collapsed slicknav_parent"';
					$result .=  "  <li$class><a href='#' role=\"menuitem\" aria-haspopup=\"true\" tabindex=\"-1\" class=\"slicknav_item\"
              style=\"outline: none;\"><span>$sm[title]</span><span class=\"slicknav_arrow\">►</span></a>\n";
					$result .= self::printSubmenu($sm['submenu'],$level+1, $group);
					$result .=  "  </li>";
				} else {
					$result .=  "  <li><a href=\"$base/$sm[url]\" role=\"menuitem\" tabindex=\"-1\">$sm[title]</a></li>\n";
				}
			}
		}
		$result .=  "</ul>\n";
    return $result;
	}  
}

?>