<?php
require_once('vendor/autoload.php');
@$f3 = Base::instance();
$f3->config('setup.ini');
$f3['LANGUAGE'] = strtolower($f3['APP.lang']);
$f3->run();
?>