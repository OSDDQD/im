<?php
require_once('Broadcast.php');
require_once('Mapper.php');
require_once('Cache.php');
require_once('helpers.php');

class Im
{
    protected $vb;
    protected $mapper;
    protected $cache;
    protected $broadcast;

    public function __construct()
    {
        global $vbulletin;
        $this->vb = $vbulletin;

        $this->mapper = new Mapper();
        $this->cache = new Cache();
        $this->broadcast = new Broadcast();
    }

    public function getChannelList()
    {

    }

    public function createChannel(array $users)
    {

    }

    public function deleteMessage($messageId)
    {

    }

    public function deleteChannel($channelId)
    {

    }

    public function markRead($channelId)
    {

    }

    public function sendMessage($text, $channelId)
    {

    }

    public function getMessages($channelId, $page = 1)
    {

    }
}