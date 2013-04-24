<?php

require_once __DIR__.'/../vendor/autoload.php';

$producer = new Bc\Mq\Producer('localhost', 4000);
$producer->produce('default', sprintf('It is now %s!', date('Y-m-d H:i:s')));
