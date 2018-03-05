<?php

namespace Application\Form;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Form\Form;

class UserForm extends Form {

    public function __construct() {



        parent::__construct('user');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'first_name',
            'type' => 'text',
            'options' => [
                'label' => 'First name',
            ],
        ]);
        $this->add([
            'name' => 'last_name',
            'type' => 'text',
            'options' => [
                'label' => 'Last name',
            ],
        ]);

        $this->add([
            'name' => 'login',
            'type' => 'text',
            'options' => [
                'label' => 'Login',
            ],
        ]);

        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Password',
            ],
        ]);

        $this->add([
            'name' => 'confirm-password',
            'type' => 'password',
            'options' => [
                'label' => 'Confirm password',
            ],
        ]);

        $this->add([
            'name' => 'email',
            'type' => 'email',
            'options' => [
                'label' => 'Email',
            ],
        ]);

        $this->add([
            'name' => 'role_id',
            'type' => 'select',
            'options' => [
                'disable_inarray_validator' => true,
                'label' => 'Role',
                'empty_option' => 'Please choose a role',
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
