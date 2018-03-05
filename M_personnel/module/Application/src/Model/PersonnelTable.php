<?php

namespace Application\Model;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Application\Model\Personnel;

class PersonnelTable extends AbstractTableGateway {

    private $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {

        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(array('id', 'first_name', 'last_name', 'middle_name', 'email', 'phone', 'region', 'district', 'affiliation', 'current_jod', 'last_training_date', 'type_of_training', 'length_of_training', 'training_organization', 'training_certificate', 'date_certificate_issued', 'Comments', 'time_worked'));
        $sqlSelect->join('region', ' region.id = personnel.region ', array('region_name'), 'left')
                ->join('district', ' district.id = personnel.district ', array('district_name'), 'left');
        $resultSet = $this->tableGateway->selectWith($sqlSelect);
        return $resultSet;
    }

    public function getPersonnel($id) {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function savePersonnel(Personnel $personnel) {

        $last_name = strtoupper($personnel->last_name);
        $first_name = strtoupper($personnel->first_name);
        $middle_name = strtoupper($personnel->middle_name);

        $data = array(
            'last_name' => $last_name,
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'phone' => $personnel->phone,
            'email' => $personnel->email,
            'region' => $personnel->region,
            'district' => $personnel->district,
            'affiliation' => $personnel->affiliation,
            'current_jod' => $personnel->current_jod,
            'time_worked' => $personnel->time_worked,
            'last_training_date' => date("Y-m-d", strtotime($personnel->last_training_date)),
            'type_of_training' => $personnel->type_of_training,
            'length_of_training' => $personnel->length_of_training,
            'training_organization' => $personnel->training_organization,
            'training_certificate' => $personnel->training_certificate,
            'date_certificate_issued' =>  date("Y-m-d", strtotime($personnel->date_certificate_issued)),
            'Comments' => $personnel->Comments,
        );


        $id = (int) $personnel->id;

        if ($id == 0) {

            $this->tableGateway->insert($data);
        } else {
            if ($this->getPersonnel($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Provider id does not exist');
            }
        }
    }

    public function deletePersonnel($id) {
        $this->tableGateway->delete(array('id' => (int) $id));
    }

    public function getRegions() {
        $dbAdapter = $this->tableGateway->getAdapter();
        $sql = 'SELECT id, region_name FROM region  ORDER by region_name asc ';
        $statement = $dbAdapter->query($sql);
        $result = $statement->execute();
        return $result;
    }

    public function getDistrict($q) {
        $db = $this->tableGateway->getAdapter();
        $sql = "SELECT id,district_name,region FROM district WHERE region = '" . $q . "'";
        $statement = $db->query($sql);
        $result = $statement->execute();
//        print_r($result);
        return $result;
    }
    
    public function DistrictName($district) {
        $db = $this->tableGateway->getAdapter();
        $sql = "SELECT id, district_name FROM district WHERE id = '" . $district . "'";
        $statement = $db->query($sql);
        $result = $statement->execute();

        foreach ($result as $res) {
            $district_name = $res['district_name'];
            $id = $res['id'];
        }
//       die(print_r($id));
        return array('district_id' => $id, 'district_name' => $district_name);
    }

    public function report($affiliation, $current_job, $type_of_training, $region, $district) {
        $db = $this->tableGateway->getAdapter();
        $sql = 'SELECT personnel.`id`, `last_name`, `first_name`, `middle_name`, `phone`, `email`, personnel.`region`, personnel.`district`, `affiliation`, `current_jod`, `time_worked`, `last_training_date`, `length_of_training`, `type_of_training`, `training_organization`, `training_certificate`, `date_certificate_issued`, `Comments`, region_name,district_name FROM `personnel`,region,district where personnel.region=region.id and personnel.district=district.id';
       
        if (!empty($affiliation)) {
            $sql = $sql . ' and affiliation="' . $affiliation . '"';
        }
        if (!empty($current_job)) {
            $sql = $sql . ' and current_jod="' . $current_job . '"';
        }
 if (!empty($type_of_training)) {
            $sql = $sql . ' and type_of_training="' . $type_of_training . '"';
        }
        if (!empty($region)) {
            $sql = $sql . ' and personnel.region=' . $region;
        }

        if (!empty($district)) {
            $sql = $sql . ' and personnel.district=' . $district;
        }

      


//die($sql);
        $statement = $db->query($sql);
        $result = $statement->execute();
        return $result;
    }

}
