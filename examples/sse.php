<?php

use SimpleEventStream\Application\EventStream;

require_once __DIR__ . '/../vendor/autoload.php';

function uuid4(): string
{
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf(
        '%s%s-%s-%s-%s-%s%s%s',
        str_split(bin2hex($data), 4)
    );
}

$id = uuid4();
$eventStream = new EventStream($id);
$eventStream->start();

for ($i = 1; $i <= 100; $i++) {
    $eventStream->sendProgress($i);
    sleep(2);
}

$eventStream->close();
