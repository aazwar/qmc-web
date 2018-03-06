<?php
namespace Ajax;

class Rating extends \Fuwafuwa\AjaxController {
  function rate() {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    SQL('INSERT INTO rating VALUES(?,?,?,?,?)', $data['department_id'], $data['channel_id'], date('Y-m-d\TH:i:s'), $data['rating'], $data['review']);
    print "Ok";
  }
  
  function retrieve() {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $data = SQL('SELECT c.name, date, rating, review FROM chat_user c 
      JOIN rating r ON c.channel_id = r.channel_id
      WHERE department_id = ?
      ORDER BY date DESC', $data['department_id']);
    $res = ["reviews" => $data]; 
    print(json_encode($res));
  }
}
