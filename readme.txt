=== Redis Object Cache ===
Contributors:      ericmann, ethitter
Tags:              cache, object cache, redis
Requires at least: 3.0.1
Tested up to:      3.9
Stable tag:        1.0
License:           GPLv2 or later
License URI:       http://www.gnu.org/licenses/gpl-2.0.html

A persistent object cache powered by Redis.

== Description ==

Object caching backend using Redis for persistent storage. Implements all methods specified by WordPress Core. Supports multisite.

The plugin supports both the [Redis PECL module](http://pecl.php.net/package/redis) and the [Predis library](https://github.com/nrk/predis) to connect to Redis.

**You must install the Redis server before using this plugin!**

== Installation ==

1. Install and configure Redis. There is a good tutorial [here](http://www.saltwebsites.com/2012/install-redis-245-service-centos-6).
2. Install the [Redis PECL module](http://pecl.php.net/package/redis) or place the Predis library in the `/wp-content/predis` directory.
3. Add `object-cache.php` to the `wp-content` directory. It is a drop-in file, not a plugin, so it belongs in the `wp-content` directory, not the `plugins` directory.
4. By default, the script will connect to Redis at 127.0.0.1:6379. See the *Connecting to Redis* FAQ for further options.

== Frequently Asked Questions ==

= Connecting to Redis =

By default, the plugin uses `127.0.0.1` and `6379` as the default host and port when creating a new client instance; the default database of `0` is also used. Three constants are provided to override these default values.

Specify `WP_REDIS_BACKEND_HOST`, `WP_REDIS_BACKEND_PORT`, and `WP_REDIS_BACKEND_DB` to set the necessary, non-default connection values for your Redis instance.

= Prefixing Cache Keys =

The constant `WP_CACHE_KEY_SALT` is provided to add a prefix to all cache keys used by the plugin. If running two single instances of WordPress from the same Redis instance, this constant could be used to avoid overlap in cache keys. Note that special handling is not needed for WordPress Multisite.

== Changelog ==

= 1.0 =
* Initial public release.

== Upgrade Notice ==

= 1.0 =
Initial public release.
