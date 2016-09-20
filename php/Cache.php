<?php
class Cache
{
    const DB_NUM = 0;

    protected $redis;

    protected $vb;

    protected $prefix;

    /**
     * Create a new Cache instance.
     */
    public function __construct()
    {
        global $vbulletin;
        $this->vb = $vbulletin;

        $this->prefix = $this->vb->options['im_cache_prefix'];

        $this->redis = new Redis();
        $this->redis->connect($this->vb->options['im_redis_host'], $this->vb->options['im_redis_port']);
        $this->redis->select(self::DB_NUM);
    }

    /**
     * Get an item from the cache.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->redis->get($this->prefix.$key);
    }

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param  string  $key
     * @param  \DateTime|int  $ttl
     * @param  mixed $value
     * @return mixed
     */
    public function set($key, $value, $ttl = 0)
    {
        return $this->redis->set($this->prefix.$key, $value, $ttl);
    }

    /**
     * Remove item from the cache.
     *
     * @param  string  $key
     * @return mixed
     */
    public function delete($key)
    {
        return $this->redis-delete($this->prefix.$key);
    }

    /**
     * Get an item from the cache, or store the default value.
     *
     * @param  string  $key
     * @param  \DateTime|int  $ttl
     * @param  \Closure  $callback
     * @return mixed
     */
    public function remember($key, $ttl, Closure $callback)
    {
        // If the item exists in the cache we will just return this immediately
        // otherwise we will execute the given Closure and cache the result
        // of that execution for the given number of minutes in storage.
        if (!is_null($value = $this->get($key))) {
            return $value;
        }

        $this->set($key, $value = $callback(), $ttl);

        return $value;
    }

    /**
     * Verify if the specified key exists.
     *
     * @param   string $key
     * @return  bool: If the key exists, return TRUE, otherwise return FALSE.
     */
    public function has($key)
    {
        return $this->redis->exists($this->prefix.$key);
    }

    /**
     * Removes all entries from the current database.
     *
     * @return  bool: Always TRUE.
     */
    public function flush()
    {
        $this->redis->flushDB();
    }

    /**
     * Disconnects from the Redis instance, except when pconnect is used.
     */
    public function __destruct()
    {
        $this->redis->close();
    }
}