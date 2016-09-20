<?php
class Mapper
{
    private $vb;

    public function __construct()
    {
        global $vb;
        $this->vb = $vb;
    }

    public function storeMessage($text, $channelId)
    {

    }

    public function deleteMessage($id)
    {

    }

    public function storeChannel()
    {
        $this->checkChannel();
    }

    public function getChannel($id, $page = 1)
    {

    }

    public function getChannels($userId)
    {

    }

    public function addInChannel($userId, $channelId)
    {

    }

    public function removeFromChannel($userId, $channelId)
    {

    }

    public function removeChannel($channelId)
    {

    }

    private function checkChannel()
    {

    }
}