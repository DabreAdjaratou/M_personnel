<?php

namespace Application\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Role;

class RoleTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getRole($id) {
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

    public function saveRole(Role $role) {
        $data = [
            'code' => $role->code,
            'name' => $role->name,
            'description' => $role->description,
            'status' => $role->status,
        ];

        $id = (int) $role->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->getRole($id)) {
            throw new RuntimeException(sprintf(
                    'Cannot update role with identifier %d; does not exist', $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteRole($id) {
        $this->tableGateway->delete(['id' => (int) $id]);
    }

    function roleExists($role_name, $role_code) {
        $dbAdapter = $this->tableGateway->getAdapter();
        $sql = "SELECT count(name) as nombre FROM role WHERE name='" . $role_name . "' or code='" . $role_code . "'";
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        foreach ($result as $res) {
            $nombre = $res['nombre'];
        }
        return $nombre;
    }

    function privilege($ressource) {
//        $dbAdapter = $this->tableGateway->getAdapter();
//        $sql = "SELECT * FROM ressource";
//        $statement = $dbAdapter->query($sql);
//        $result = $statement->execute();
//        $ar = [];
//        foreach ($result as $r) {
//            $ar []= $r['display_name'];
//        }
//        $n = sizeof($ar);
//
//        for ($i = 0; $i < $n; $i++) {

            $dbAdapter = $this->tableGateway->getAdapter();
            $sql2 = "SELECT role_ressource_map.`id`, `role_name`, role_ressource_map.`ressource_name`, `privilege_name`, `privilege_display_name`,ressource.display_name FROM `role_ressource_map`, ressource  WHERE role_ressource_map.ressource_name= ressource.ressource_name and ressource.display_name='".$ressource."'  order by display_name";
            $statement2 = $dbAdapter->query($sql2);
            $result2 = $statement2->execute();
            $d=[];
            $selectedData=[];
            foreach ($result2 as $r2) {
                
                $selectedData[$ressource]= array_push($selectedData, $r2['privilege_name']);
                                }
                                               
           return ['privileges' => $selectedData];
//           
//        return $result2;         
//        }
       
       
    }

    function ressource() {
        $dbAdapter = $this->tableGateway->getAdapter();
        $sql = "SELECT * FROM ressource";
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        $ar = [];
        foreach ($result as $r) {
            $ar[] = $r['display_name'];
        }
//     die(print_r($r));
        return $ar;
    }

}
