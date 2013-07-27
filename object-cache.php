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
 * Adds a value to cache on a specific server.
 *
 * Using a server_key value, the object can be stored on a specified server as opposed
 * to a random server in the stack. Note that this method will add the key/value to the
 * _cache object as part of the runtime cache. It will add it to an array for the
 * specified server_key.
 *
 * @param string $server_key     The key identifying the server to store the value on.
 * @param string $key            The key under which to store the value.
 * @param mixed  $value          The value to store.
 * @param string $group          The group value appended to the $key.
 * @param int    $expiration     The expiration time, defaults to 0.
 *
 * @return bool                     Returns TRUE on success or FALSE on failure.
 */
function wp_cache_add_by_key( $server_key, $key, $value, $group = '', $expiration = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->addByKey( $server_key, $key, $value, $group, $expiration );
}

/**
 * Append data to an existing item.
 *
 * This method should throw an error if it is used with compressed data. This
 * is an expected behavior. Memcached casts the value to be appended to the initial value to the
 * type of the initial value. Be careful as this leads to unexpected behavior at times. Due to
 * how memcached treats types, the behavior has been mimicked in the internal cache to produce
 * similar results and improve consistency. It is recommend that appends only occur with data of
 * the same type.
 *
 * @link http://www.php.net/manual/en/memcached.append.php
 *
 * @param string $key    The key under which to store the value.
 * @param mixed  $value  Must be string as appending mixed values is not well-defined
 * @param string $group  The group value appended to the $key.
 *
 * @return bool             Returns TRUE on success or FALSE on failure.
 */
function wp_cache_append( $key, $value, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->append( $key, $value, $group );
}

/**
 * Append data to an existing item by server key.
 *
 * This method should throw an error if it is used with compressed data. This
 * is an expected behavior. Memcached casts the value to be appended to the initial value to the
 * type of the initial value. Be careful as this leads to unexpected behavior at times. Due to
 * how memcached treats types, the behavior has been mimicked in the internal cache to produce
 * similar results and improve consistency. It is recommend that appends only occur with data of
 * the same type.
 *
 * @link http://www.php.net/manual/en/memcached.appendbykey.php
 *
 * @param string $server_key     The key identifying the server to store the value on.
 * @param string $key            The key under which to store the value.
 * @param mixed  $value          Must be string as appending mixed values is not well-defined
 * @param string $group          The group value appended to the $key.
 *
 * @return bool                     Returns TRUE on success or FALSE on failure.
 */
function wp_cache_append_by_key( $server_key, $key, $value, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->appendByKey( $server_key, $key, $value, $group );
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
 * @link http://www.php.net/manual/en/memcached.decrement.php
 *
 * @param string $key    The key under which to store the value.
 * @param int    $offset The amount by which to decrement the item's value.
 * @param string $group  The group value appended to the $key.
 *
 * @return int|bool         Returns item's new value on success or FALSE on failure.
 */
function wp_cache_decrement( $key, $offset = 1, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->decrement( $key, $offset, $group );
}

/**
 * Decrement a numeric item's value.
 *
 * Same as wp_cache_decrement. Original WordPress caching backends use wp_cache_decr. I
 * want both spellings to work.
 *
 * @link http://www.php.net/manual/en/memcached.decrement.php
 *
 * @param string $key    The key under which to store the value.
 * @param int    $offset The amount by which to decrement the item's value.
 * @param string $group  The group value appended to the $key.
 *
 * @return int|bool         Returns item's new value on success or FALSE on failure.
 */
function wp_cache_decr( $key, $offset = 1, $group = '' ) {
	return wp_cache_decrement( $key, $offset, $group );
}

/**
 * Remove the item from the cache.
 *
 * Remove an item from memcached with identified by $key after $time seconds. The
 * $time parameter allows an object to be queued for deletion without immediately
 * deleting. Between the time that it is queued and the time it's deleted, add,
 * replace, and get will fail, but set will succeed.
 *
 * @link http://www.php.net/manual/en/memcached.delete.php
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
 * Remove the item from the cache by server key.
 *
 * Remove an item from memcached with identified by $key after $time seconds. The
 * $time parameter allows an object to be queued for deletion without immediately
 * deleting. Between the time that it is queued and the time it's deleted, add,
 * replace, and get will fail, but set will succeed.
 *
 * @link http://www.php.net/manual/en/memcached.deletebykey.php
 *
 * @param string $server_key The key identifying the server to store the value on.
 * @param string $key        The key under which to store the value.
 * @param string $group      The group value appended to the $key.
 * @param int    $time       The amount of time the server will wait to delete the item in seconds.
 *
 * @return bool                     Returns TRUE on success or FALSE on failure.
 */
function wp_cache_delete_by_key( $server_key, $key, $group = '', $time = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->deleteByKey( $server_key, $key, $group, $time );
}

/**
 * Fetch the next result.
 *
 * @link http://www.php.net/manual/en/memcached.fetch.php
 *
 * @return  array|bool   Returns the next result or FALSE otherwise.
 */
function wp_cache_fetch() {
	global $wp_object_cache;

	return $wp_object_cache->fetch();
}

/**
 * Fetch all remaining results from the last request.
 *
 * @return  array|bool  Returns the results or FALSE on failure.
 */
function wp_cache_fetch_all() {
	global $wp_object_cache;

	return $wp_object_cache->fetchAll();
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
 * Gets an object from cache based on $key and $group. In order to fully support the $cache_cb and $cas_token
 * parameters, the runtime cache is ignored by this function if either of those values are set. If either of
 * those values are set, the request is made directly to the memcached server for proper handling of the
 * callback and/or token.
 *
 * Note that the $deprecated and $found args are only here for compatibility with the native wp_cache_get function.
 *
 * @link http://www.php.net/manual/en/memcached.get.php
 *
 * @param string      $key        The key under which to store the value.
 * @param string      $group      The group value appended to the $key.
 * @param null|string $cache_cb   Read-through caching callback.
 * @param null|float  $cas_token  The variable to store the CAS token in.
 *
 * @return bool|mixed               Cached object value.
 */
function wp_cache_get( $key, $group = '', $cache_cb = null, &$cas_token = null ) {
	global $wp_object_cache;

	/**
	 * Handles situations where the $force argument for the wp_cache_get function in core may be used. It is only
	 * used once in all of WP Core and since the function does not do anything with it, it is pointless to support.
	 * I'm catching the issue here to avoid conflicts.
	 */
	if ( true === $cache_cb )
		$cache_cb = null;

	if ( func_num_args() > 2 )
		return $wp_object_cache->get( $key, $group, '', false, $cache_cb, $cas_token );
	else
		return $wp_object_cache->get( $key, $group );
}

/**
 * Retrieve object from cache from specified server.
 *
 * Gets an object from cache based on $key, $group and $server_key. In order to fully support the $cache_cb and $cas_token
 * parameters, the runtime cache is ignored by this function if either of those values are set. If either of
 * those values are set, the request is made directly to the memcached server for proper handling of the
 * callback and/or token.
 *
 * @link http://www.php.net/manual/en/memcached.getbykey.php
 *
 * @param string      $server_key The key identifying the server to store the value on.
 * @param string      $key        The key under which to store the value.
 * @param string      $group      The group value appended to the $key.
 * @param null|string $cache_cb   Read-through caching callback.
 * @param null|float  $cas_token  The variable to store the CAS token in.
 *
 * @return bool|mixed               Cached object value.
 */
function wp_cache_get_by_key( $server_key, $key, $group = '', $cache_cb = null, &$cas_token = null ) {
	global $wp_object_cache;

	if ( func_num_args() > 3 )
		return $wp_object_cache->getByKey( $server_key, $key, $group, $cache_cb, $cas_token );
	else
		return $wp_object_cache->getByKey( $server_key, $key, $group );
}

/**
 * Request multiple keys without blocking.
 *
 * @link http://www.php.net/manual/en/memcached.getdelayed.php
 *
 * @param string|array $keys       Array or string of key(s) to request.
 * @param string|array $groups     Array or string of group(s) for the key(s). See buildKeys for more on how these are handled.
 * @param bool         $with_cas   Whether to request CAS token values also.
 * @param null         $value_cb   The result callback or NULL.
 *
 * @return bool                     Returns TRUE on success or FALSE on failure.
 */
function wp_cache_get_delayed( $keys, $groups = '', $with_cas = false, $value_cb = null ) {
	global $wp_object_cache;

	return $wp_object_cache->getDelayed( $keys, $groups, $with_cas, $value_cb );
}

/**
 * Request multiple keys without blocking from a specified server.
 *
 * @link http://www.php.net/manual/en/memcached.getdelayed.php
 *
 * @param string       $server_key The key identifying the server to store the value on.
 * @param string|array $keys       Array or string of key(s) to request.
 * @param string|array $groups     Array or string of group(s) for the key(s). See buildKeys for more on how these are handled.
 * @param bool         $with_cas   Whether to request CAS token values also.
 * @param null         $value_cb   The result callback or NULL.
 *
 * @return bool                     Returns TRUE on success or FALSE on failure.
 */
function wp_cache_get_delayed_by_key( $server_key, $keys, $groups = '', $with_cas = false, $value_cb = null ) {
	global $wp_object_cache;

	return $wp_object_cache->getDelayedByKey( $server_key, $keys, $groups, $with_cas, $value_cb );
}

/**
 * Gets multiple values from memcached in one request.
 *
 * See the buildKeys method definition to understand the $keys/$groups parameters.
 *
 * @link http://www.php.net/manual/en/memcached.getmulti.php
 *
 * @param array        $keys       Array of keys to retrieve.
 * @param string|array $groups     If string, used for all keys. If arrays, corresponds with the $keys array.
 * @param null|array   $cas_tokens The variable to store the CAS tokens for the found items.
 * @param int          $flags      The flags for the get operation.
 *
 * @return bool|array               Returns the array of found items or FALSE on failure.
 */
function wp_cache_get_multi( $keys, $groups = '', &$cas_tokens = null, $flags = null ) {
	global $wp_object_cache;

	if ( func_num_args() > 2 )
		return $wp_object_cache->getMulti( $keys, $groups, '', $cas_tokens, $flags );
	else
		return $wp_object_cache->getMulti( $keys, $groups );
}

/**
 * Gets multiple values from memcached in one request by specified server key.
 *
 * See the buildKeys method definition to understand the $keys/$groups parameters.
 *
 * @link http://www.php.net/manual/en/memcached.getmultibykey.php
 *
 * @param string       $server_key The key identifying the server to store the value on.
 * @param array        $keys       Array of keys to retrieve.
 * @param string|array $groups     If string, used for all keys. If arrays, corresponds with the $keys array.
 * @param null|array   $cas_tokens The variable to store the CAS tokens for the found items.
 * @param int          $flags      The flags for the get operation.
 *
 * @return bool|array               Returns the array of found items or FALSE on failure.
 */
function wp_cache_get_multi_by_key( $server_key, $keys, $groups = '', &$cas_tokens = null, $flags = null ) {
	global $wp_object_cache;

	if ( func_num_args() > 3 )
		return $wp_object_cache->getMultiByKey( $server_key, $keys, $groups, $cas_tokens, $flags );
	else
		return $wp_object_cache->getMultiByKey( $server_key, $keys, $groups );
}

/**
 * Retrieve a Memcached option value.
 *
 * @link http://www.php.net/manual/en/memcached.getoption.php
 *
 * @param int $option One of the Memcached::OPT_* constants.
 *
 * @return mixed        Returns the value of the requested option, or FALSE on error.
 */
function wp_cache_get_option( $option ) {
	global $wp_object_cache;

	return $wp_object_cache->getOption( $option );
}

/**
 * Return the result code of the last option.
 *
 * @link http://www.php.net/manual/en/memcached.getresultcode.php
 *
 * @return int  Result code of the last Memcached operation.
 */
function wp_cache_get_result_code() {
	global $wp_object_cache;

	return $wp_object_cache->getResultCode();
}

/**
 * Return the message describing the result of the last operation.
 *
 * @link http://www.php.net/manual/en/memcached.getresultmessage.php
 *
 * @return string   Message describing the result of the last Memcached operation.
 */
function wp_cache_get_result_message() {
	global $wp_object_cache;

	return $wp_object_cache->getResultMessage();
}

/**
 * Get server information by key.
 *
 * @link http://www.php.net/manual/en/memcached.getserverbykey.php
 *
 * @param string $server_key The key identifying the server to store the value on.
 *
 * @return array                Array with host, post, and weight on success, FALSE on failure.
 */
function wp_cache_get_server_by_key( $server_key ) {
	global $wp_object_cache;

	return $wp_object_cache->getServerByKey( $server_key );
}

/**
 * Get the list of servers in the pool.
 *
 * @link http://www.php.net/manual/en/memcached.getserverlist.php
 *
 * @return array    The list of all servers in the server pool.
 */
function wp_cache_get_server_list() {
	global $wp_object_cache;

	return $wp_object_cache->getServerList();
}

/**
 * Get server pool statistics.
 *
 * @link http://www.php.net/manual/en/memcached.getstats.php
 *
 * @return array    Array of server statistics, one entry per server.
 */
function wp_cache_get_stats() {
	global $wp_object_cache;

	return $wp_object_cache->getStats();
}

/**
 * Get server pool memcached version information.
 *
 * @link http://www.php.net/manual/en/memcached.getversion.php
 *
 * @return array    Array of server versions, one entry per server.
 */
function wp_cache_get_version() {
	global $wp_object_cache;

	return $wp_object_cache->getVersion();
}

/**
 * Increment a numeric item's value.
 *
 * @link http://www.php.net/manual/en/memcached.increment.php
 *
 * @param string $key    The key under which to store the value.
 * @param int    $offset The amount by which to increment the item's value.
 * @param string $group  The group value appended to the $key.
 *
 * @return int|bool         Returns item's new value on success or FALSE on failure.
 */
function wp_cache_increment( $key, $offset = 1, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->increment( $key, $offset, $group );
}

/**
 * Increment a numeric item's value.
 *
 * This is the same as wp_cache_increment, but kept for back compatibility. The original
 * WordPress caching backends use wp_cache_incr. I want both to work.
 *
 * @link http://www.php.net/manual/en/memcached.increment.php
 *
 * @param string $key    The key under which to store the value.
 * @param int    $offset The amount by which to increment the item's value.
 * @param string $group  The group value appended to the $key.
 *
 * @return int|bool         Returns item's new value on success or FALSE on failure.
 */
function wp_cache_incr( $key, $offset = 1, $group = '' ) {
	return wp_cache_increment( $key, $offset, $group );
}

/**
 * Prepend data to an existing item.
 *
 * This method should throw an error if it is used with compressed data. This is an expected behavior.
 * Memcached casts the value to be prepended to the initial value to the type of the initial value. Be
 * careful as this leads to unexpected behavior at times. For instance, prepending (float) 45.23 to
 * (int) 23 will result in 45, because the value is first combined (45.2323) then cast to "integer"
 * (the original value), which will be (int) 45. Due to how memcached treats types, the behavior has been
 * mimicked in the internal cache to produce similar results and improve consistency. It is recommend
 * that prepends only occur with data of the same type.
 *
 * @link http://www.php.net/manual/en/memcached.prepend.php
 *
 * @param string $key    The key under which to store the value.
 * @param string $value  Must be string as prepending mixed values is not well-defined.
 * @param string $group  The group value prepended to the $key.
 *
 * @return bool             Returns TRUE on success or FALSE on failure.
 */
function wp_cache_prepend( $key, $value, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->prepend( $key, $value, $group );
}

/**
 * Append data to an existing item by server key.
 *
 * This method should throw an error if it is used with compressed data. This is an expected behavior.
 * Memcached casts the value to be prepended to the initial value to the type of the initial value. Be
 * careful as this leads to unexpected behavior at times. For instance, prepending (float) 45.23 to
 * (int) 23 will result in 45, because the value is first combined (45.2323) then cast to "integer"
 * (the original value), which will be (int) 45. Due to how memcached treats types, the behavior has been
 * mimicked in the internal cache to produce similar results and improve consistency. It is recommend
 * that prepends only occur with data of the same type.
 *
 * @link http://www.php.net/manual/en/memcached.prependbykey.php
 *
 * @param string $server_key     The key identifying the server to store the value on.
 * @param string $key            The key under which to store the value.
 * @param string $value          Must be string as prepending mixed values is not well-defined.
 * @param string $group          The group value prepended to the $key.
 *
 * @return bool                     Returns TRUE on success or FALSE on failure.
 */
function wp_cache_prepend_by_key( $server_key, $key, $value, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->prependByKey( $server_key, $key, $value, $group );
}

/**
 * Replaces a value in cache.
 *
 * This method is similar to "add"; however, is does not successfully set a value if
 * the object's key is not already set in cache.
 *
 * @link http://www.php.net/manual/en/memcached.replace.php
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
 * Replaces a value in cache on a specific server.
 *
 * This method is similar to "addByKey"; however, is does not successfully set a value if
 * the object's key is not already set in cache.
 *
 * @link http://www.php.net/manual/en/memcached.addbykey.php
 *
 * @param string $server_key     The key identifying the server to store the value on.
 * @param string $key            The key under which to store the value.
 * @param mixed  $value          The value to store.
 * @param string $group          The group value appended to the $key.
 * @param int    $expiration     The expiration time, defaults to 0.
 *
 * @return bool                     Returns TRUE on success or FALSE on failure.
 */
function wp_cache_replace_by_key( $server_key, $key, $value, $group = '', $expiration = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->replaceByKey( $server_key, $key, $value, $group, $expiration );
}

/**
 * Sets a value in cache.
 *
 * The value is set whether or not this key already exists in memcached.
 *
 * @link http://www.php.net/manual/en/memcached.set.php
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
 * Sets a value in cache.
 *
 * The value is set whether or not this key already exists in memcached.
 *
 * @link http://www.php.net/manual/en/memcached.set.php
 *
 * @param string $server_key     The key identifying the server to store the value on.
 * @param string $key            The key under which to store the value.
 * @param mixed  $value          The value to store.
 * @param string $group          The group value appended to the $key.
 * @param int    $expiration     The expiration time, defaults to 0.
 *
 * @return bool                     Returns TRUE on success or FALSE on failure.
 */
function wp_cache_set_by_key( $server_key, $key, $value, $group = '', $expiration = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->setByKey( $server_key, $key, $value, $group, $expiration );
}

/**
 * Set multiple values to cache at once.
 *
 * By sending an array of $items to this function, all values are saved at once to
 * memcached, reducing the need for multiple requests to memcached. The $items array
 * keys and values are what are stored to memcached. The keys in the $items array
 * are merged with the $groups array/string value via buildKeys to determine the
 * final key for the object.
 *
 * @param array        $items      An array of key/value pairs to store on the server.
 * @param string|array $groups     Group(s) to merge with key(s) in $items.
 * @param int          $expiration The expiration time, defaults to 0.
 *
 * @return bool                     Returns TRUE on success or FALSE on failure.
 */
function wp_cache_set_multi( $items, $groups = '', $expiration = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->setMulti( $items, $groups, $expiration );
}

/**
 * Set multiple values to cache at once on specified server.
 *
 * By sending an array of $items to this function, all values are saved at once to
 * memcached, reducing the need for multiple requests to memcached. The $items array
 * keys and values are what are stored to memcached. The keys in the $items array
 * are merged with the $groups array/string value via buildKeys to determine the
 * final key for the object.
 *
 * @param string       $server_key The key identifying the server to store the value on.
 * @param array        $items      An array of key/value pairs to store on the server.
 * @param string|array $groups     Group(s) to merge with key(s) in $items.
 * @param int          $expiration The expiration time, defaults to 0.
 *
 * @return bool                     Returns TRUE on success or FALSE on failure.
 */
function wp_cache_set_multi_by_key( $server_key, $items, $groups = 'default', $expiration = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->setMultiByKey( $server_key, $items, $groups, $expiration );
}

/**
 * Set a Memcached option.
 *
 * @link http://www.php.net/manual/en/memcached.setoption.php
 *
 * @param int   $option Option name.
 * @param mixed $value  Option value.
 *
 * @return bool             Returns TRUE on success or FALSE on failure.
 */
function wp_cache_set_option( $option, $value ) {
	global $wp_object_cache;

	return $wp_object_cache->setOption( $option, $value );
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
 * Adds a group or set of groups to the list of non-persistent groups.
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
 * Adds a group or set of groups to the list of non-Memcached groups.
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

		$this->redis = new Predis\Client( '' );

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
	 * @param   string $server_key     The key identifying the server to store the value on.
	 * @param   bool   $byKey          True to store in internal cache by key; false to not store by key
	 *
	 * @return  bool                        Returns TRUE on success or FALSE on failure.
	 */
	public function add( $key, $value, $group = 'default', $expiration = 0, $server_key = '', $byKey = false ) {
		$derived_key = $this->buildKey( $key, $group );

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
		$result = $this->redis->setex( $derived_key, $value, $expiration );

		return $result;
	}

	/**
	 * Remove the item from the cache.
	 *
	 * Remove an item from memcached with identified by $key after $time seconds. The
	 * $time parameter allows an object to be queued for deletion without immediately
	 * deleting. Between the time that it is queued and the time it's deleted, add,
	 * replace, and get will fail, but set will succeed.
	 *
	 * @link http://www.php.net/manual/en/memcached.delete.php
	 *
	 * @param   string $key        The key under which to store the value.
	 * @param   string $group      The group value appended to the $key.
	 * @param   int    $time       The amount of time the server will wait to delete the item in seconds.
	 * @param   string $server_key The key identifying the server to store the value on.
	 * @param   bool   $byKey      True to store in internal cache by key; false to not store by key
	 *
	 * @return  bool                    Returns TRUE on success or FALSE on failure.
	 */
	public function delete( $key, $group = 'default', $time = 0, $server_key = '', $byKey = false ) {
		$derived_key = $this->buildKey( $key, $group );

		// Remove from no_mc_groups array
		if ( in_array( $group, $this->no_redis_groups ) ) {
			if ( isset( $this->cache[$derived_key] ) ) {
				unset( $this->cache[$derived_key] );
			}

			return true;
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
	 * @param   string        $server_key The key identifying the server to store the value on.
	 * @param   bool          $byKey      True to store in internal cache by key; false to not store by key
	 *
	 * @return  bool|mixed                  Cached object value.
	 */
	public function get( $key, $group = 'default', $server_key = '', $byKey = false ) {
		$derived_key = $this->buildKey( $key, $group );

		if ( ! in_array( $group, $this->no_redis_groups ) ) {
			$value = $this->redis->get( $derived_key );
		} else {
			if ( isset( $this->cache[$derived_key] ) ) {
				return is_object( $this->cache[$derived_key] ) ? clone $this->cache[$derived_key] : $this->cache[$derived_key];
			} elseif ( in_array( $group, $this->no_redis_groups ) ) {
				return false;
			} else {
				$value = $this->redis->get( $derived_key );
			}
		}

		$this->add_to_internal_cache( $derived_key, $value );

		return is_object( $value ) ? clone $value : $value;
	}

	/**
	 * Sets a value in cache.
	 *
	 * The value is set whether or not this key already exists in memcached.
	 *
	 * @link http://www.php.net/manual/en/memcached.set.php
	 *
	 * @param   string $key        The key under which to store the value.
	 * @param   mixed  $value      The value to store.
	 * @param   string $group      The group value appended to the $key.
	 * @param   int    $expiration The expiration time, defaults to 0.
	 * @param   string $server_key The key identifying the server to store the value on.
	 * @param   bool   $byKey      True to store in internal cache by key; false to not store by key
	 *
	 * @return  bool                    Returns TRUE on success or FALSE on failure.
	 */
	public function set( $key, $value, $group = 'default', $expiration = 0, $server_key = '' ) {
		$derived_key = $this->buildKey( $key, $group );

		// If group is a non-Redis group, save to runtime cache, not Redis
		if ( in_array( $group, $this->no_redis_groups ) ) {
			$this->add_to_internal_cache( $derived_key, $value );

			return true;
		}

		// Save to Redis
		$result = $this->redis->setex( $derived_key, $value, absint( $expiration ) );

		$this->add_to_internal_cache( $derived_key, $value );

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
	public function buildKey( $key, $group = 'default' ) {
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
		$derived_key = $this->buildKey( $key, $group );

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

		$groups = array_fill_keys( $groups, true );
		$this->global_groups = array_merge( $this->global_groups, $groups );
	}

	/**
	 * Sets the list of groups not to be cached by Redis.
	 *
	 * @param array $groups List of groups that are to be ignored.
	 */
	function add_non_persistent_groups( $groups ) {
		$groups = (array) $groups;

		$groups = array_fill_keys( $groups, true );
		$this->no_redis_groups = array_merge( $this->no_redis_groups, $groups );
	}
}
