<?php

class Application_Model_UserMapper
{
    protected $_dbTable;

    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Không hợp lệ !');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_User');
        }
        return $this->_dbTable;
    }

    public function save(Application_Model_User $user)
    {
        $data = array(
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
            'email'   => $user->getEmail(),
            'password' => md5($user->getPassword()),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $this->getDbTable()->insert($data);
    }

    public function saveEdit(Application_Model_User $user)
    {
        $data = array(
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
            'email'   => $user->getEmail(),
            'password' => md5($user->getPassword()),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $dataNoPass = array(
            'name' => $user->getName(),
            'phone' => $user->getPhone(),
            'email'   => $user->getEmail(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $id = $user->getId();

        // var_dump('sss'); die;
        if ($user->getPassword() != null) {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        } else {
            $this->getDbTable()->update($dataNoPass, array('id = ?' => $id));
        }
    }



    public function find($id, Application_Model_User $user)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $user->setId($row->id)
            ->setName($row->name)
            ->setPhone($row->phone)
            ->setEmail($row->email)
            ->setPassword($row->password)
            ->setCreatedAt($row->created_at)
            ->setUpdatedAt($row->updated_at);
        return $row;
    }

    public function fetchAll()
    {
        $result = $this->getDbTable()->select()->where('deleted_at IS NULL');
        $resultSet = $this->getDbTable()->fetchAll($result);
        // var_dump($resultSet); die;
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_User();
            $entry->setId($row->id)
                ->setName($row->name)
                ->setPhone($row->phone)
                ->setEmail($row->email)
                ->setPassword($row->password)
                ->setCreatedAt($row->created_at)
                ->setUpdatedAt($row->updated_at);
            $entries[] = $entry;
        }

        return $entries;
    }


    public function delete($id)
    {
        return $this->getDbTable()->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ], array('id = ?' => $id));
    }
}
