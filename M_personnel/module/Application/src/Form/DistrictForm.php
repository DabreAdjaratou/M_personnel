<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;

class DistrictForm extends Form {

    public function __construct() {
        
        // we want to ignore the name passed
        parent::__construct('district');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'district_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Name of District',
            ),
        ));
        $this->add(array(
            'name' => 'region',
            'type' => 'select',
            'options' => array(
                'disable_inarray_validator' => true,
                'label' => 'Region',
                'empty_option' => 'Please Choose A Region',
//               
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }

   

}
