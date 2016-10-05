<?php
class Mapper
{
    const TYPE_DIRECT = 'D';
    const TYPE_PUBLIC = 'P';

    const TABLE_CHANNEL = 'im_channel';
    const TABLE_MESSAGE = 'im_message';
    const TABLE_RELATION = 'im_relation';

    protected $vb;
    protected $db;

    protected $t_channel;
    protected $t_message;
    protected $t_relation;

    public function __construct()
    {
        global $vb;

        $this->vb = $vb;
        $this->db = $this->vb->db;

        $this->t_channel = TABLE_PREFIX.self::TABLE_CHANNEL;
        $this->t_message = TABLE_PREFIX.self::TABLE_MESSAGE;
        $this->t_relation = TABLE_PREFIX.self::TABLE_RELATION;
    }

    public function createMessage($text, $channelId)
    {

    }

    public function deleteMessage($id)
    {

    }

    public function storeChannel($type, $name = '')
    {
        $this->db->query_write("
            INSERT INTO " . $this->t_channel . " (type, name)
            VALUES (
                    '" . $type . "',
                    '" . $name . "'
            )
        ");

        return true;
    }

    public function getChannel($id, $page = 1)
    {

    }

    public function getChannels($userId)
    {

    }

    public function addUserInChannel($userId, $channelId)
    {

    }

    public function removeUserFromChannel($userId, $channelId)
    {

    }

    public function removeChannel($channelId)
    {

    }

    public function updateLastMessageId($channelId, $messageId)
    {

    }

    private function checkSubscribe($channelId)
    {
        $query = $this->db->query_first("
            SELECT *
			FROM " . $this->t_channel . " AS channel
			WHERE channel_id = " . $channelId . " AND user_id = " . $this->vb->userinfo['userid'] . "
        ");

        if($query['channel_id']) {
            return true;
        }

        return false;
    }

    public function increaseUnreadCounter($channelId)
    {

    }

    public function markChannel($channelId)
    {
        $this->db->query_write("
            UPDATE " . $this->t_relation . "
            SET unread = 0
            WHERE channel_id = " . $channelId . " AND user_id = " . $this->vb->userinfo['userid'] . "
        ");

        return true;
    }
}