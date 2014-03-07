## Overview

A WordPress object cache backend that implements all available methods using Redis and either the Redis PECL library or the Predis library for PHP.

## Authors

* Eric Mann
* Erick Hitter

## Installation
1. Install and configure Redis. There is a good tutorial [here](http://www.saltwebsites.com/2012/install-redis-245-service-centos-6).
2. Install the [Redis PECL module](http://pecl.php.net/package/redis) or the Predis library (included in this repository as a submodule) in the `/wp-content/predis` directory (since that's where the object cache expects it to reside if it's to be used).
3. Add `object-cache.php` to the wp-content directory. It is a drop-in file, not a plugin, so it belongs in the wp-content directory, not the plugins directory.
4. By default, the script will connect to Redis at 127.0.0.1:6379. See the *Connecting to Redis* section for further options.

### Connecting to Redis ###

By default, the plugin uses `127.0.0.1` and `6379` as the default host and port when creating a new client instance; the default database of `0` is also used. Three constants are provided to override these default values.

Specify `WP_REDIS_BACKEND_HOST`, `WP_REDIS_BACKEND_PORT`, and `WP_REDIS_BACKEND_DB` to set the necessary, non-default connection values for your Redis instance.

### Prefixing Cache Keys ###
The constant `WP_CACHE_KEY_SALT` is provided to add a prefix to all cache keys used by the plugin. If running two single instances of WordPress from the same Redis instance, this constant could be used to avoid overlap in cache keys. Note that special handling is not needed for WordPress Multisite.