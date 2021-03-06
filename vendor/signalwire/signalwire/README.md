# SignalWire PHP

This library provides a client for the Signalwire LaML and REST services.

It allows you to create calls, send messages, and generate LAML responses.

# Installation

Install the package via [Composer](https://getcomposer.org/).

```bash
composer require signalwire/signalwire
```

If your environment does not handle autoloading you must `require` the autoload file generated by Composer:
```php
require 'path-to/vendor/autoload.php';
```

# Usage

In order to use the `SignalWire\Rest\Client` namespace you must set the environment variable `SIGNALWIRE_API_HOSTNAME` that point to your SignalWire host!

Using [$_ENV](http://php.net/manual/it/reserved.variables.environment.php):
```php
$_ENV['SIGNALWIRE_API_HOSTNAME'] = "example.signalwire.com";
```

Using [putenv](http://php.net/manual/it/function.putenv.php):

```php
putenv("SIGNALWIRE_API_HOSTNAME=example.signalwire.com");
```

Under Apache you can use [SetEnv](https://httpd.apache.org/docs/2.4/mod/mod_env.html#setenv) directive.
### Setup the client
```php
use SignalWire\Rest\Client;
// You can retrieve Project and Token from your SignalWire Space!
$client = new Client($project, $token);

// See the examples below to use $client ..
```

### Make Call
```php
$call = $client->calls->create(
  "+11234567890", // Call this number
  "+10987654321", // From a valid SignalWire number
  array(
    "url" => "https://example.com/laml/voice.xml" // Valid LaML
  )
);

echo "Call ID: " . $call->sid;
```

### Send Message
```php
$message = $client->messages->create(
  "+11234567890", // Text this number
  array(
    "from" => "+10987654321", // From a valid SignalWire number
    "body" => "Hello from SignalWire!"
  )
);

echo "Message ID: " . $message->sid;
```

### Generating LaML
```php
$response = new SignalWire\LaML();
$response->say("Welcome to SignalWire!");
$response->play("https://example.com/mp3/sound.mp3", array("loop" => 5));

echo $response;
```

LaML output:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<Response>
  <Say>Welcome to SignalWire!</Say>
  <Play loop="5">https://example.com/mp3/sound.mp3</Play>
</Response>
```

# Migration
Do you want to start using SignalWire in your current application? You can easily migrate the code with minimal changes!

To use the Rest client set the env variable `SIGNALWIRE_API_HOSTNAME` as described in [Usage](#usage) and then:
```php
// Replace the namespace from:
use Twilio\Rest\Client;

// to ..
use SignalWire\Rest\Client;

// .. and create a new client using your SignalWire Project and Token!
$client = new Client($project, $token);

// Now use $client like you did before!
```
> For calls and messages you should also change the `from` numbers with your SignalWire valid numbers.

To generate `LaML`:

```php
// Replace these lines..
use Twilio\TwiML;
$response = new TwiML;

// With ..
use SignalWire\LaML;
$response = new LaML;

// Now use $response like you did before!
```

# Contribute

You can try the library locally using Docker.

Set your Host, Project and Token in `.env`
```bash
$ cp .env.example .env
$ vim .env
```

Build the image
```bash
$ ./docker-dev build
```

To start using the Rest Client try out the `examples/index.php`:

```bash
$ ./docker-dev run --rm php php examples/index.php
```

To generate LaML `examples/laml.php`:

```bash
$ ./docker-dev run --rm php php examples/laml.php
```

## Tests

Run tests using Docker:

```bash
$ ./docker-dev run --rm php php vendor/bin/phpunit tests
```

# Copyright

Copyright (c) 2018 SignalWire Inc. See [LICENSE](https://github.com/signalwire/signalwire-php/blob/master/LICENSE) for
further details.