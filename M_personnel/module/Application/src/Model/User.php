<?php

namespace Application\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class User implements InputFilterAwareInterface {

    public $id;
    public $first_name;
    public $last_name;
    public $login;
    public $password;
    public $email;
    public $status;
    public $created_on;
    public $role_id;

    private$inputFilter;
    
    public function exchangeArray(array $data) {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->first_name = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->last_name = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->login = !empty($data['login']) ? $data['login'] : null;
        $this->password = !empty($data['password']) ? $data['password'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->status = !empty($data['status']) ? $data['status'] : null;
        $this->created_on = !empty($data['created_on']) ? $data['created_on'] : null;
        $this->role_id = !empty($data['role_id']) ? $data['role_id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
    }
    
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'login'=> $this->login,
            'password'=> $this->password,
            'email'=> $this->email,
            'status'=> $this->status,
            'created_on'=> $this->created_on,
            'role_id'     => $this->role_id,
        ];
    }
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'first_name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                                              
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'last_name',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        
                        
                    ],
                ],
            ],
        ]);
        
        
        $inputFilter->add([
            'name' => 'login',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        
                        
                    ],
                ],
            ],
        ]);
        
        
        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min'=>6,
                        
                        
                    ],
                ],
            ],
        ]);
$inputFilter->add([
            'name' => 'confirm-password',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                       'min'=>6,
                        
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                       
                        
                    ],
                ],
            ],
        ]);
        
        
        $inputFilter->add([
            'name' => 'status',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        
                                            ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'role_id',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
//           
        ]);
        
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}


