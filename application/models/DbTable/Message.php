<?php

class Application_Model_DbTable_Message extends Zend_Db_Table_Abstract
{

    protected $_name = 'message';

    public function addMessage($user_id, $title, $text){
        $data = array(
            'user_id' => $user_id,
            'title' => $title,
            'text' => $text,
            'created_at' => time(),
        );
        $this->insert($data);
    }

    public function getMessages($sort){
        $sortby = $sort['sortby'];
        $orderby = $sort['orderby'];

        $messages = $this->fetchAll(null, "$sortby $orderby")->toArray();
        foreach($messages as $id=>$message){
            $users = new Application_Model_DbTable_User();
            $user = $users->getUser($message['user_id']);
            $messages[$id]['name'] = $user['name'];
            $messages[$id]['email'] = $user['email'];
        }
        return $messages;
    }
}

