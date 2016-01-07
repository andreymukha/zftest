<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'user';

    public function addUser($name, $email, $user_agent){
        $data = array(
            'name' => $name,
            'email' => $email,
            'http_user_agent' => $user_agent,
            'created_at' => time(),
        );
        return $this->insert($data);
    }

    public function getUser($user_id = NULL, $email = NULL){
        $select = $this->select();

        if($user_id !== NULL){
            $select->where('user_id = ?', $user_id);
        }elseif($email !== NULL){
            $select->where('email = ?', $email);
        }

        $stmt = $select->query();
        $result = $stmt->fetchAll();
        return $result[0];
    }
}

