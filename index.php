<?php

include('Bramus/Router/Router.php');

$router = new Bramus\Router\Router();


$router->match('POST', 'subscribe/(.*)', function($topic){
  // subscribe topic
  $data = file_get_contents("php://input");
  $data = json_decode($data, true);
  if(!isset($data['url'])) {
    return;
  }

  $filePath = __DIR__.'/data/subscriptions.json';
  $subscriptions = file_get_contents($filePath) ?? '[]';
  $subscriptions = json_decode($subscriptions, true);
  $subscriptions[$topic] = $subscriptions[$topic] ?? [];

  if(!in_array($data['url'], $subscriptions[$topic])) {
    $subscriptions[$topic][] = $data['url'];
    $content = json_encode($subscriptions);
    file_put_contents($filePath, $content);
  }
  echo "Subscription added";
});


$router->match('POST', 'publish/(.*)', function($topic){
  // publish topic
  $filePath = __DIR__.'/data/subscriptions.json';
  $subscriptions = file_get_contents($filePath) ?? '[]';
  $subscriptions = json_decode($subscriptions, true);
  $subscriptions[$topic] = $subscriptions[$topic] ?? [];

  $data = file_get_contents("php://input");
  $postString = json_encode([
    "topic"=> $topic,
    "data"=> $data
  ]);

  foreach($subscriptions[$topic] as $url) {
    echo http_send_post($url, $postString);
  }
  $n = count($subscriptions[$topic]);
  echo "Message published to $n subscribers";
});


$router->match('POST', 'event', function(){
  // print data
  $data = file_get_contents("php://input");
  echo $data;
});


$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo 'HTTP/1.1 404 Not Found';
});



$router->run();




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
