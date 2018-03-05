<?php


namespace Application\Form;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Form\Form;

class RoleForm extends Form {

    public function __construct() {



        parent::__construct('role');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'code',
            'type' => 'text',
            'options' => [
                'label' => 'Role code',
            ],
        ]);
        $this->add([
            'name' => 'name',
            'type' => 'text',
            'options' => [
                'label' => 'Role name',
            ],
        ]);

        $this->add([
            'name' => 'description',
            'type' => 'textarea',
            'options' => [
                'label' => 'Description',
            ],
        ]);

        

        $this->add([
            'name' => 'status',
            'type' => 'select',
            'options' => [
                'label' => 'Status',
                'value_options' => array(
                    'active' => 'Active',
                    'inactive' => 'Inactive'
                ),
            ],
        ]);


        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton',
            ],
        ]);
    }

}


