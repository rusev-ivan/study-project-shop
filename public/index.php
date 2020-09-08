<?php

use Shop\Http\RequestFactory;
use Shop\Http\Response;
use Shop\Http\ResponseSender;

require __DIR__ . '/../vendor/autoload.php';

$request = RequestFactory::fromGlobals();


$name = $request->getQueryParams()['name'] ?? 'Guest';

$response = (new Response('Hello, ' . $name . '!'))
    ->withHeader('X-Developer', 'Rusev');

### Sending

$emitter = new ResponseSender();
$emitter->send($response);

