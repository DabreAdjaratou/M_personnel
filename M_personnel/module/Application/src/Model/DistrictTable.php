<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class DistrictTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(array('id', 'district_name', 'region'));
        $sqlSelect->join('region', 'region.id= district.region ', array('region_name'), 'left');
        $sqlSelect->order('district_name asc');

        $resultSet = $this->tableGateway->selectWith($sqlSelect);
        return $resultSet;
    }

    public function getDistrict($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveDistrict(District $district) {
        $data = array(
            'district_name' => strtoupper($district->district_name),
            'region' => $district->region,
        );

        $id = (int) $district->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getDistrict($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('District id does not exist');
            }
        }
    }

    public function deleteDistrict($id) {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

    public function getRegion() {
        $dbAdapter = $this->tableGateway->getAdapter();
        $sql = 'SELECT id, region_name FROM region ORDER by region_name asc ';
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        return $result;
    }

    function ditrictExists($district,$region) {
        $dbAdapter = $this->tableGateway->getAdapter();
        $sql = "SELECT count(district_name) as nombre FROM district WHERE district_name='" . $district . "' and region='".$region."';";
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        foreach ($result as $res) {
            $nombre = $res['nombre'];
        }
        return $nombre;
    }

}
