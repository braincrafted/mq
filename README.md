BcMq
====

[![Build Status](https://travis-ci.org/braincrafted/mq.png?branch=master)](https://travis-ci.org/braincrafted/mq)

An asynchronous message queue implemented in PHP (mostly for fun and pleasure).

By [Florian Eckerstorfer](http://florianeckerstorfer.com).


Installation
------------

The recommended way of installing BcMq is through [Composer](http://getcomposer.org):

    {
        "require": {
            "braincrafted/mq": "dev-master"
        }
    }


Usage
-----

BcMq requires two distinct scripts, a server and a consumer. The server needs to run as long new messages should be accepted. Whenever a new message arrives the server invokes the consumer in the background and instantley closes the connection.

Messages can be produces using the included Producer or by writing a JSON object to the configured port.

There are examples for server, consumer and producer in the `examples` directory.

- [`server.php`](https://github.com/braincrafted/mq/blob/master/examples/server.php)
- [`consumer.php`](https://github.com/braincrafted/mq/blob/master/examples/consumer.php)
- [`producer.php`](https://github.com/braincrafted/mq/blob/master/examples/producer.php)


License
-------

    The MIT License (MIT)

    Copyright (c) 2013 Florian Eckerstorfer

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.
