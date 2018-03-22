<?php
namespace Ajax;

class Video extends \Fuwafuwa\AjaxController {
  function retrieve() {
    $data = SQL('SELECT * FROM video ORDER BY date DESC');
    print(json_encode($data));
  }
}
