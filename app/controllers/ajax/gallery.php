<?php
namespace Ajax;

class Gallery extends \Fuwafuwa\AjaxController {
  function retrieve() {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $data = SQL('SELECT c.name, date, rating, review FROM chat_user c 
      JOIN rating r ON c.channel_id = r.channel_id
      WHERE department_id = ?
      ORDER BY date DESC', data.department_id);
    $res = ["reviews" => $data]; 
    print(json_encode($res));
  }
  
  function category_list() {
    $data = SQL('SELECT * FROM case_category');
    $res = array_map(function($e) { 
      $e["cover_image"] = "images/case_history/" . $e["cover_image"]; 
      return $e;
    }, $data);
    print(json_encode($res));
  }
  
  function retrieve_case() {
    extract($this->request); // tanggal. nofaktur
    $data = SQL('SELECT * FROM case_history WHERE category = ?', $id);
    $res = array_map(function($e) { 
      $e["before_image"] = "images/case_history/" . $e["before_image"]; 
      $e["after_image"] = "images/case_history/" . $e["after_image"]; 
      return $e;
    }, $data);
    print(json_encode($res));
  }
}
