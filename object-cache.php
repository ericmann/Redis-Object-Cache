<?php
/**
 * Adds a value to cache.
 *
 * If the specified key already exists, the value is not stored and the function
 * returns false.
 *
 * @param string $key        The key under which to store the value.
 * @param mixed  $value      The value to store.
 * @param string $group      The group value appended to the $key.
 * @param int    $expiration The expiration time, defaults to 0.
 *
 * @return bool                 Returns TRUE on success or FALSE on failure.
 */
function wp_cache_add( $key, $value, $group = '', $expiration = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->add( $key, $value, $group, $expiration );
}

/**
 * Closes the cache.
 *
 * This function has ceased to do anything since WordPress 2.5. The
 * functionality was removed along with the rest of the persistent cache. This
 * does not mean that plugins can't implement this function when they need to
 * make sure that the cache is cleaned up after WordPress no longer needs it.
 *
 * @since 2.0.0
 *
 * @return  bool    Always returns True
 */
function wp_cache_close() {
	return true;
}

/**
 * Decrement a numeric item's value.
 *
 * @param string $key    The key under which to store the value.
 * @param int    $offset The amount by which to decrement the item's value.
 * @param string $group  The group value appended to the $key.
 *
 * @return int|bool         Returns item's new value on success or FALSE on failure.
 */
function wp_cache_decr( $key, $offset = 1, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->decrement( $key, $offset, $group );
}

/**
 * Remove the item from the cache.
 *
 * @param string $key    The key under which to store the value.
 * @param string $group  The group value appended to the $key.
 * @param int    $time   The amount of time the server will wait to delete the item in seconds.
 *
 * @return bool             Returns TRUE on success or FALSE on failure.
 */
function wp_cache_delete( $key, $group = '', $time = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->delete( $key, $group, $time );
}

/**
 * Invalidate all items in the cache.
 *
 * @param int $delay  Number of seconds to wait before invalidating the items.
 *
 * @return bool             Returns TRUE on success or FALSE on failure.
 */
function wp_cache_flush( $delay = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->flush( $delay );
}

/**
 * Retrieve object from cache.
 *
 * Gets an object from cache based on $key and $group.
 *
 * @param string      $key        The key under which to store the value.
 * @param string      $group      The group value appended to the $key.
 *
 * @return bool|mixed               Cached object value.
 */
function wp_cache_get( $key, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->get( $key, $group );
}

/**
 * Get server pool statistics.
 *
 * @return array    Array of server statistics, one entry per server.
 */
function wp_cache_get_stats() {
	global $wp_object_cache;

	return $wp_object_cache->stats();
}

/**
 * Increment a numeric item's value.
 *
 * @param string $key    The key under which to store the value.
 * @param int    $offset The amount by which to increment the item's value.
 * @param string $group  The group value appended to the $key.
 *
 * @return int|bool         Returns item's new value on success or FALSE on failure.
 */
function wp_cache_incr( $key, $offset = 1, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->increment( $key, $offset, $group );
}

/**
 * Replaces a value in cache.
 *
 * This method is similar to "add"; however, is does not successfully set a value if
 * the object's key is not already set in cache.
 *
 * @param string $key        The key under which to store the value.
 * @param mixed  $value      The value to store.
 * @param string $group      The group value appended to the $key.
 * @param int    $expiration The expiration time, defaults to 0.
 *
 * @return bool                 Returns TRUE on success or FALSE on failure.
 */
function wp_cache_replace( $key, $value, $group = '', $expiration = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->replace( $key, $value, $group, $expiration );
}

/**
 * Sets a value in cache.
 *
 * The value is set whether or not this key already exists in Redis.
 *
 * @param string $key        The key under which to store the value.
 * @param mixed  $value      The value to store.
 * @param string $group      The group value appended to the $key.
 * @param int    $expiration The expiration time, defaults to 0.
 *
 * @return bool                 Returns TRUE on success or FALSE on failure.
 */
function wp_cache_set( $key, $value, $group = '', $expiration = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->set( $key, $value, $group, $expiration );
}

/**
 * Sets up Object Cache Global and assigns it.
 *
 * @global  WP_Object_Cache $wp_object_cache    WordPress Object Cache
 * @return  void
 */
function wp_cache_init() {
	global $wp_object_cache;
	$wp_object_cache = new WP_Object_Cache();
}

/**
 * Adds a group or set of groups to the list of Redis groups.
 *
 * @param   string|array $groups     A group or an array of groups to add.
 *
 * @return  void
 */
function wp_cache_add_global_groups( $groups ) {
	global $wp_object_cache;
	$wp_object_cache->add_global_groups( $groups );
}

/**
 * Adds a group or set of groups to the list of non-Redis groups.
 *
 * @param   string|array $groups     A group or an array of groups to add.
 *
 * @return  void
 */
function wp_cache_add_non_persistent_groups( $groups ) {
	global $wp_object_cache;
	$wp_object_cache->add_non_persistent_groups( $groups );
}

class WP_Object_Cache {

	/**
	 * Holds the Redis client.
	 *
	 * @var Predis\Client
	 */
	public $redis;

	/**
	 * Holds the non-Redis objects.
	 *
	 * @var array
	 */
	public $cache = array();

	/**
	 * List of global groups.
	 *
	 * @var array
	 */
	public $global_groups = array( 'users', 'userlogins', 'usermeta', 'site-options', 'site-lookup', 'blog-lookup', 'blog-details', 'rss' );

	/**
	 * List of groups not saved to Redis.
	 *
	 * @var array
	 */
	public $no_redis_groups = array( 'comment', 'counts' );

	/**
	 * Prefix used for global groups.
	 *
	 * @var string
	 */
	public $global_prefix = '';

	/**
	 * Prefix used for non-global groups.
	 *
	 * @var string
	 */
	public $blog_prefix = '';

	/**
	 * Instantiate the Redis class.
	 *
	 * Instantiates the Redis class.
	 *
	 * @param   null $persistent_id      To create an instance that persists between requests, use persistent_id to specify a unique ID for the instance.
	 */
	public function __construct() {
		require_once 'predis/autoload.php';

		$redis = array(
			'host' => '127.0.0.1',
			'port' => 6379,
		);

		if ( defined( 'WP_REDIS_BACKEND_HOST' ) && WP_REDIS_BACKEND_HOST ) {
			$redis['host'] = WP_REDIS_BACKEND_HOST;
		}
		if ( defined( 'WP_REDIS_BACKEND_PORT' ) && WP_REDIS_BACKEND_PORT ) {
			$redis['port'] = WP_REDIS_BACKEND_PORT;
		}
		if ( defined( 'WP_REDIS_BACKEND_DB' ) && WP_REDIS_BACKEND_DB ) {
			$redis['database'] = WP_REDIS_BACKEND_DB;
		}

		$this->redis = new Predis\Client( $redis );
		unset( $redis );

		global $blog_id, $table_prefix;

		/**
		 * This approach is borrowed from Sivel and Boren. Use the salt for easy cache invalidation and for
		 * multi single WP installs on the same server.
		 */
		if ( ! defined( 'WP_CACHE_KEY_SALT' ) ) {
			define( 'WP_CACHE_KEY_SALT', '' );
		}

		// Assign global and blog prefixes for use with keys
		if ( function_exists( 'is_multisite' ) ) {
			$this->global_prefix = ( is_multisite() || defined( 'CUSTOM_USER_TABLE' ) && defined( 'CUSTOM_USER_META_TABLE' ) ) ? '' : $table_prefix;
			$this->blog_prefix   = ( is_multisite() ? $blog_id : $table_prefix ) . ':';
		}
	}

	/**
	 * Adds a value to cache.
	 *
	 * If the specified key already exists, the value is not stored and the function
	 * returns false.
	 *
	 * @param   string $key            The key under which to store the value.
	 * @param   mixed  $value          The value to store.
	 * @param   string $group          The group value appended to the $key.
	 * @param   int    $expiration     The expiration time, defaults to 0.
	 *
	 * @return  bool                        Returns TRUE on success or FALSE on failure.
	 */
	public function add( $key, $value, $group = 'default', $expiration = 0 ) {
		$derived_key = $this->build_key( $key, $group );

		// If group is a non-Redis group, save to runtime cache, not Redis
		if ( in_array( $group, $this->no_redis_groups ) ) {

			// Add does not set the value if the key exists; mimic that here
			if ( isset( $this->cache[$derived_key] ) ) {
				return false;
			}

			$this->add_to_internal_cache( $derived_key, $value );

			return true;
		}

		if ( $this->redis->exists( $derived_key ) ) {
			return false;
		}

		// Save to Redis
		$expiration = absint( $expiration );
		if ( $expiration ) {
			$result = $this->redis->setex( $derived_key, $expiration, $this->prepare_value_for_redis( $value ) );
		} else {
			$result = $this->redis->set( $derived_key, $this->prepare_value_for_redis( $value ) );
		}

		return $result;
	}

	/**
	 * Remove the item from the cache.
	 *
	 * @param   string $key        The key under which to store the value.
	 * @param   string $group      The group value appended to the $key.
	 * @return  bool               Returns TRUE on success or FALSE on failure.
	 */
	public function delete( $key, $group = 'default' ) {
		$derived_key = $this->build_key( $key, $group );

		// Remove from no_mc_groups array
		if ( in_array( $group, $this->no_redis_groups ) ) {
			if ( isset( $this->cache[$derived_key] ) ) {
				unset( $this->cache[$derived_key] );

				return true;
			}
		}

		$result = $this->redis->del( $derived_key );

		unset( $this->cache[$derived_key] );

		return $result;
	}

	/**
	 * Invalidate all items in the cache.
	 *
	 * @param   int $delay      Number of seconds to wait before invalidating the items.
	 *
	 * @return  bool                Returns TRUE on success or FALSE on failure.
	 */
	public function flush( $delay = 0 ) {
		$delay = absint( $delay );
		if ( $delay ) {
			sleep( $delay );
		}

		$this->cache = array();
		$result = $this->redis->flushall();

		return $result;
	}

	/**
	 * Retrieve object from cache.
	 *
	 * Gets an object from cache based on $key and $group.
	 *
	 * @param   string        $key        The key under which to store the value.
	 * @param   string        $group      The group value appended to the $key.
	 *
	 * @return  bool|mixed                  Cached object value.
	 */
	public function get( $key, $group = 'default' ) {
		$derived_key = $this->build_key( $key, $group );

		if ( in_array( $group, $this->no_redis_groups ) ) {
			if ( isset( $this->cache[$derived_key] ) ) {
				return is_object( $this->cache[$derived_key] ) ? clone $this->cache[$derived_key] : $this->cache[$derived_key];
			} elseif ( in_array( $group, $this->no_redis_groups ) ) {
				return false;
			}
		}

		if ( $this->redis->exists( $derived_key ) ) {
			$value = $this->restore_value_from_redis( $this->redis->get( $derived_key ) );
		} else {
			return false;
		}

		$this->add_to_internal_cache( $derived_key, $value );

		return is_object( $value ) ? clone $value : $value;
	}

	/**
	 * Sets a value in cache.
	 *
	 * The value is set whether or not this key already exists in Redis.
	 *
	 * @param   string $key        The key under which to store the value.
	 * @param   mixed  $value      The value to store.
	 * @param   string $group      The group value appended to the $key.
	 * @param   int    $expiration The expiration time, defaults to 0.
	 *
	 * @return  bool                    Returns TRUE on success or FALSE on failure.
	 */
	public function set( $key, $value, $group = 'default', $expiration = 0 ) {
		$derived_key = $this->build_key( $key, $group );

		// If group is a non-Redis group, save to runtime cache, not Redis
		if ( in_array( $group, $this->no_redis_groups ) ) {
			$this->add_to_internal_cache( $derived_key, $value );

			return true;
		}

		// Save to Redis
		$expiration = absint( $expiration );
		if ( $expiration ) {
			$result = $this->redis->setex( $derived_key, $expiration, $this->prepare_value_for_redis( $value ) );
		} else {
			$result = $this->redis->set( $derived_key, $this->prepare_value_for_redis( $value ) );
		}

		$this->add_to_internal_cache( $derived_key, $value );

		return $result;
	}

	/**
	 * Increment a Redis counter by the amount specified
	 *
	 * @param  string $key
	 * @param  int    $offset
	 * @param  string $group
	 * @return bool
	 */
	public function increment( $key, $offset = 1, $group = 'default' ) {
		$derived_key = $this->build_key( $key, $group );
		$offset = (int) $offset;

		// If group is a non-Redis group, save to runtime cache, not Redis
		if ( in_array( $group, $this->no_redis_groups ) ) {
			$value = $this->get_from_runtime_cache( $derived_key );
			$value += $offset;
			$this->add_to_internal_cache( $derived_key, $value );

			return true;
		}

		// Save to Redis
		$result = $this->redis->incrBy( $derived_key, $offset );

		$this->add_to_internal_cache( $derived_key, (int) $this->redis->get( $derived_key ) );

		return $result;
	}

	/**
	 * Decrement a Redis counter by the amount specified
	 *
	 * @param  string $key
	 * @param  int    $offset
	 * @param  string $group
	 * @return bool
	 */
	public function decrement( $key, $offset = 1, $group = 'default' ) {
		$derived_key = $this->build_key( $key, $group );
		$offset = (int) $offset;

		// If group is a non-Redis group, save to runtime cache, not Redis
		if ( in_array( $group, $this->no_redis_groups ) ) {
			$value = $this->get_from_runtime_cache( $derived_key );
			$value -= $offset;
			$this->add_to_internal_cache( $derived_key, $value );

			return true;
		}

		// Save to Redis
		$result = $this->redis->decrBy( $derived_key, $offset );

		$this->add_to_internal_cache( $derived_key, (int) $this->redis->get( $derived_key ) );

		return $result;
	}

	/**
	 * Builds a key for the cached object using the blog_id, key, and group values.
	 *
	 * @author  Ryan Boren   This function is inspired by the original WP Memcached Object cache.
	 * @link    http://wordpress.org/extend/plugins/memcached/
	 *
	 * @param   string $key        The key under which to store the value.
	 * @param   string $group      The group value appended to the $key.
	 *
	 * @return  string
	 */
	public function build_key( $key, $group = 'default' ) {
		if ( empty( $group ) ) {
			$group = 'default';
		}

		if ( false !== array_search( $group, $this->global_groups ) ) {
			$prefix = $this->global_prefix;
		} else {
			$prefix = $this->blog_prefix;
		}

		return preg_replace( '/\s+/', '', WP_CACHE_KEY_SALT . "$prefix$group:$key" );
	}

	/**
	 * Prepare a value for storage in Redis, which only accepts strings
	 *
	 * @param mixed $value
	 * @return string
	 */
	protected function prepare_value_for_redis( $value ) {
		$value = maybe_serialize( $value );

		return $value;
	}

	/**
	 * Restore a value stored in Redis to its original data type
	 *
	 * @param string $value
	 * @return mixed
	 */
	protected function restore_value_from_redis( $value ) {
		$value = maybe_unserialize( $value );

		return $value;
	}

	/**
	 * Simple wrapper for saving object to the internal cache.
	 *
	 * @param   string $derived_key    Key to save value under.
	 * @param   mixed  $value          Object value.
	 */
	public function add_to_internal_cache( $derived_key, $value ) {
		$this->cache[ $derived_key ] = $value;
	}

	/**
	 * Get a value specifically from the internal, run-time cache, not Redis.
	 *
	 * @param   int|string $key        Key value.
	 * @param   int|string $group      Group that the value belongs to.
	 *
	 * @return  bool|mixed              Value on success; false on failure.
	 */
	public function get_from_runtime_cache( $key, $group ) {
		$derived_key = $this->build_key( $key, $group );

		if ( isset( $this->cache[ $derived_key ] ) ) {
			return $this->cache[ $derived_key ];
		}

		return false;
	}

	/**
	 * Sets the list of global groups.
	 *
	 * @param array $groups List of groups that are global.
	 */
	function add_global_groups( $groups ) {
		$groups = (array) $groups;

		$this->global_groups = array_unique( array_merge( $this->global_groups, $groups ) );
	}

	/**
	 * Sets the list of groups not to be cached by Redis.
	 *
	 * @param array $groups List of groups that are to be ignored.
	 */
	function add_non_persistent_groups( $groups ) {
		$groups = (array) $groups;

		$this->no_redis_groups = array_unique( array_merge( $this->no_redis_groups, $groups ) );
	}
}
