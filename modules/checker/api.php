<?php
class ServicesAPI {
  private $api_url = 'http://api.ip-games.ru';
  private $api_token = '';
  private $api_version = '2.2';

  public function __construct($api_token = '', $api_version = '2.2') {
    $this->api_token = $api_token;
    $this->api_version = $api_version;
  }

  public function method($name, $params = array()) {
    $url = $this->api_url . "/method/" . $name;
		
    return json_decode($this->request($url, $params), true);
  }

  private function request($url, $params = array()) {
    $params['key'] = $this->api_token;
    $params['v'] = $this->api_version;

    $url = $url.(is_array($params) && count($params) ? '?'.http_build_query($params) : '');

    if (function_exists('curl_init')) {
      $ch = curl_init($url);

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_TIMEOUT, 5);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
    }

    return @file_get_contents($url);
  }
}