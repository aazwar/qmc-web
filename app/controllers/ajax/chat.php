<?php
namespace Ajax;

class Chat extends \Fuwafuwa\AjaxController {
  private function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
      // 32 bits for "time_low"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

      // 16 bits for "time_mid"
      mt_rand( 0, 0xffff ),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand( 0, 0x0fff ) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand( 0, 0x3fff ) | 0x8000,

      // 48 bits for "node"
      mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
  }
  
  function register() {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    SQL('INSERT OR REPLACE INTO chat_user VALUES(?, ?, ?)', $data['channel_id'], $data['name'], $data['push_token']);
    print "Success";
  }
  
  function change_name() {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    SQL('UPDATE chat_user SET name = ? WHERE channel_id = ?', $data['name'], $data['channel_id']);
  }
  
  function send() {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    // guard to check automatically register non member
    if(FSQL1('SELECT COUNT(1) FROM chat_user WHERE channel_id = ?', $data['channel_id']) == 0) {
      $data['name'] = substr(str_replace('-', '_', $data['channel_id']), 0, 10);
      SQL('INSERT OR REPLACE INTO chat_user VALUES(?, ?, ?)', $data['channel_id'], $data['name'], $data['push_token']);
    }
    foreach($data['messages'] as $m) {
      SQL('INSERT INTO messages VALUES(?,?,?,?,?)', $data['channel_id'], $m['id'], $m['user_id'], $m['datetime'], $m['text']);
    }
    print "Success";
  }
  
  function retrieve() {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $sql = "SELECT id, user_id, datetime, text FROM messages WHERE channel_id = ? AND datetime > ? ORDER BY datetime";
    $res = SQL($sql, $data['channel_id'], $data['last_date']);
    print(json_encode($res));
  }
  
  function user_list() {
    $sql = 'SELECT c.name, c.channel_id from chat_user c 
      JOIN  chat_last_time ct ON c.channel_id = ct.channel_id
      ORDER BY ct.datetime DESC';
    print(json_encode(SQL($sql)));
  }
  
  function message_list() {
    extract($this->request);
    $res = SQL('SELECT * from messages WHERE channel_id = ? ORDER BY datetime', $channel_id);
    print(json_encode($res));
  }
  
  function reply() {
    extract($this->request);
    SQL('INSERT INTO messages VALUES (?, ?, ?, ?, ?)', $channel_id, $this->gen_uuid(), 2, $datetime, $text);
    print \Expo\Notification::send($channel_id, $text);
  }
  
  function test() {
    $expo = \ExponentPhpSDK\Expo::normalSetup();
    $notification = ['body' => 'Hello World!'];
    $expo->notify('QMC-c2490fcc-052d-4254-913e-cc6a7536fc89', $notification);
  }
}
