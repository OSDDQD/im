<?php
class Broadcast
{
    protected $redis;

    protected $vb;

    public function __construct()
    {
        global $vbulletin;
        $this->vb = $vbulletin;

        $this->redis = new Redis();
        $this->redis->connect($this->vb->options['im_redis_host'], $this->vb->options['im_redis_port']);
    }

    public function publish($channel = 'actions', array $data)
    {
        $this->redis->publish($channel, json_encode($data));
    }

    public function __destruct()
    {
        $this->redis->close();
    }
}