# pub-sub
Setting up a subscription

    POST /subscribe/{TOPIC}
    BODY { url: "http://localhost:8080/event"}

The above code would create a subscription for all events of {TOPIC} and forward data to http://localhost:8000/event

Publishing an event

    POST /publish/{TOPIC}
    BODY { "message": "hello"}

The above code would publish on whatever is passed in the body (as JSON) to the supplied topic in the URL. This endpoint should trigger a forwarding of the data in the body to all of the currently subscribed URL's for that topic.

Testing it all out Publishing an event
```
$ php -S localhost:8080
$ php -S localhost:8000
$ ./vendor/phpunit/phpunit/phpunit tests/SubscribePublish.php
```
The above code would set up a subscription between topic1 and http://localhost:8080/event. When the event is published in line 3, it would send both the topic and body as JSON to http://localhost:8080

The /event endpoint is just used to print the data and verify everything is working.
