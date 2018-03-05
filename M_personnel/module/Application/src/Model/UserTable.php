<?php

namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class UserTable {

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(array('id', 'first_name', 'last_name', 'email', 'status', 'role_id'));
        $sqlSelect->join('role', ' role.id = user.role_id ', array('name'), 'left');
//        die($sqlSelect);
        $resultSet = $this->tableGateway->selectWith($sqlSelect);
        return $resultSet;
    }

    public function getUser($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (!$row) {
            throw new RuntimeException(sprintf(
                    'Could not find row with identifier %d', $id
            ));
        }

        return $row;
    }

    public function saveUser(User $user) {

        $passwordHash = password_hash(($user->password), PASSWORD_DEFAULT);
        $currentDate = date('Y-m-d H:i:s');

        $data = [
            'first_name' => strtoupper($user->first_name),
            'last_name' => strtoupper($user->last_name),
            'login' => $user->login,
            'password' => $passwordHash,
            'email' => $user->email,
            'status' => $user->status,
            'created_on' => $currentDate,
            'role_id' => $user->role_id,
        ];

        $id = (int) $user->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->getUser($id)) {
            throw new RuntimeException(sprintf(
                    'Cannot update user with identifier %d; does not exist', $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteUser($id) {
        $this->tableGateway->delete(['id' => (int) $id]);
    }

    public function getRoles() {
        $dbAdapter = $this->tableGateway->getAdapter();
        $sql = 'SELECT id, code, name FROM role ORDER by name asc';
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        return $result;
    }

    function login($login) {
        $dbAdapter = $this->tableGateway->getAdapter();
        $sql = "SELECT  user.id,login, password,role_id, user.status, role.name FROM user,role WHERE user.role_id=role.id and login='" . $login . "';";
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        $selectData = [];
        foreach ($result as $res) {
            $selectData['id'] = $res['id'];
            $selectData['login'] = $res['login'];
            $selectData['password'] = $res['password'];
            $selectData['status'] = $res['status'];
            $selectData['role'] = $res['name'];
            $selectData['role_id'] = $res['role_id'];
        }
        return $selectData;
    }

    public function getRessource($role) {
        $dbAdapter = $this->tableGateway->getAdapter();
        $sql = "SELECT role_ressource_map.`id`, `role_name`, `ressource_name`,ressource.ressource_name FROM `role_ressource_map`,ressource WHERE ressource.id=role_ressource_map.ressource and role='" . $role . "';";
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        $selectData = [];
        foreach ($result as $res) {
            
            $selectData[]= $res['ressource_name'];
           
        }
//        die(print_r($selectData));
        return $selectData;
    }

     public function getRessources() {
        $dbAdapter = $this->tableGateway->getAdapter();
        $sql = 'SELECT id, ressource_name, display_name FROM ressource ORDER by ressource_name asc';
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        return $result;
    }
    
     public function getPrivileges() {
        $dbAdapter = $this->tableGateway->getAdapter();
        $sql = 'SELECT `role_name`, `ressource_name`, `privilege_name`, `privilege_display_name` FROM `role_ressource_map`';
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        return $result;
    }
}
