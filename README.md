## Overview

A WordPress object cache backend that implements all available methods using Redis and the Predis library for PHP.

## Authors 

* Eric Mann

## Installation
1. Install and configure Redis. There is a good tutorial [here](http://www.saltwebsites.com/2012/install-redis-245-service-centos-6).
2. Install Predis (included in this repository as a submodule) in the `/wp-content/predis` directory, since that's where the object cache expects it to reside.
3. Add object-cache.php to the wp-content directory. It is a drop-in file, not a plugin, so it belongs in the wp-content directory, not the plugins directory.
4. By default, the script will connect to Redis at 127.0.0.1:6379.

### Connecting to Redis ###

By default Predis uses `127.0.0.1` and `6379` as the default host and port when creating a new client
instance without specifying any connection parameter:

```php
$redis = new Predis\Client();
$redis->set('foo', 'bar');
$value = $redis->get('foo');
```

It is possible to specify the various connection parameters using URI strings or named arrays:

```php
$redis = new Predis\Client('tcp://10.0.0.1:6379');

// is equivalent to:

$redis = new Predis\Client(array(
    'scheme' => 'tcp',
    'host'   => '10.0.0.1',
    'port'   => 6379,
));
```
