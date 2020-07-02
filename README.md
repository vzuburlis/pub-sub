# pub-sub
Setting up a subscription

    POST /subscribe/{TOPIC}
    BODY { url: "http://localhost:8080/event"}

Publishing an event

    POST /publish/{TOPIC}
    BODY { "message": "hello"}

Testing it all out Publishing an event
```
$ php -S localhost:8080
$ php -S localhost:8000
$ ./vendor/phpunit/phpunit/phpunit tests/SubscribePublish.php
```
