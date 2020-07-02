<?php

include_once(__DIR__.'/../vendor/autoload.php');
use PHPUnit\Framework\TestCase;

class SubscribePublishTest extends TestCase
{

  public function test_subscribe_publish()
  {
    @unlink('data/subscriptions.json');
    $response = $this->http_send_post('http://localhost:8000/subscribe/topic1', '{ "url": "http://localhost:8080/event"}');
    $this->assertTrue(file_exists('data/subscriptions.json'));

    $response = $this->http_send_post('http://localhost:8000/publish/topic1', '{"message": "hello"}');
    $this->assertEquals($response, '{"topic":"topic1","data":"{\"message\": \"hello\"}"}');
  }

  /********************/
  function http_send_post($url, $postString) {
    $options = [
      'http' => [
        'method'  => 'POST',
        'header'  => "Content-type: application/json",
        'content' => $postString,
        'ignore_errors' => false
      ]
    ];
  
    $context = stream_context_create($options);
    return file_get_contents($url, false, $context);
  }

}
