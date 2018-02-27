<?php
  
namespace Expo;
use \Fuwafuwa\FSQL1;

class Notification {
  const EXPO_API_URL = 'https://exp.host/--/api/v2/push/send';
  static function send($channel_id, $message) {
    new \Fuwafuwa\Db();
    $token = FSQL1('SELECT push_token FROM chat_user WHERE channel_id = ?', $channel_id);
    $ch = curl_init();
    // Set cURL opts
    curl_setopt($ch, CURLOPT_URL, self::EXPO_API_URL);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'accept: application/json',
        'content-type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $postData[] = ['to' => $token, 'body' => substr($message, 0, 200)];

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = [
        'body' => curl_exec($ch),
        'status_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
    ];
    print json_encode($response);
  }
}
?>