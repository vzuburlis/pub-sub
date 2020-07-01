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
$ curl -X POST -d '{ "url": "http://localhost:8080/event"}' http://localhost:8000/subscribe/topic1
$ curl -X POST -H "Content-Type: application/json" -d '{"message": "hello"}' http://localhost:8000/publish/topic1
```
