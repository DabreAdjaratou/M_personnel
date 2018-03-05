<?php

namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\InputFilterAwareInterface;

class Personnel implements InputFilterAwareInterface {

    public $id;
    public $last_name;
    public $first_name;
    public $middle_name;
    public $phone;
    public $email;
    public $region;
    public $district;
    public $affiliation;
    public $current_jod;
    public $last_training_date;
    public $type_of_training;
    public $length_of_training;
    public $training_organization;
    public $training_certificate;
    public $date_certificate_issued;
    public $Comments;
    public $time_worked;
    protected $inputFilter;

    public function exchangeArray($data) {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->last_name = (!empty($data['last_name'])) ? $data['last_name'] : null;
        $this->first_name = (!empty($data['first_name'])) ? $data['first_name'] : null;
        $this->middle_name = (!empty($data['middle_name'])) ? $data['middle_name'] : null;
        $this->phone = (!empty($data['phone'])) ? $data['phone'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->region = (!empty($data['region'])) ? $data['region'] : null;
        $this->district = (!empty($data['district'])) ? $data['district'] : null;
        $this->affiliation = (!empty($data['affiliation'])) ? $data['affiliation'] : null;
        $this->current_jod = (!empty($data['current_jod'])) ? $data['current_jod'] : null;
        $this->time_worked = (!empty($data['time_worked'])) ? $data['time_worked'] : null;
        $this->last_training_date = (!empty($data['last_training_date'])) ? $data['last_training_date'] : null;
        $this->type_of_training = (!empty($data['type_of_training'])) ? $data['type_of_training'] : null;
        $this->training_organization = (!empty($data['training_organization'])) ? $data['training_organization'] : null;
        $this->length_of_training = (!empty($data['length_of_training'])) ? $data['length_of_training'] : null;
        $this->date_certificate_issued = (!empty($data['date_certificate_issued'])) ? $data['date_certificate_issued'] : null;
        $this->training_certificate = (!empty($data['training_certificate'])) ? $data['training_certificate'] : null;
        $this->Comments = (!empty($data['Comments'])) ? $data['Comments'] : null;
        
        $this->region_name = (!empty($data['region_name'])) ? $data['region_name'] : null;
        $this->district_name = (!empty($data['district_name'])) ? $data['district_name'] : null;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name' => 'id',
                'required' => false,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            ));
                   
            
            $inputFilter->add(array(
                'name' => 'last_name',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));


            $inputFilter->add(array(
                'name' => 'first_name',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'middle_name',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array('encoding' => 'UTF-8',),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'phone',
                'required' => true,
            ));

            $inputFilter->add(array(
                'name' => 'email',
                'required' => false,
            ));

            $inputFilter->add(array(
                'name' => 'region',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'district',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));


            $inputFilter->add(array(
                'name' => 'affiliation',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));


            $inputFilter->add(array(
                'name' => 'current_jod',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'time_worked',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));

            
           
 $inputFilter->add(array(
                'name' => 'last_training_date',
                'required' => true,
            ));

            
            $inputFilter->add(array(
                'name' => 'type_of_training',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));
            
            $inputFilter->add(array(
                'name' => 'length_of_training',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));
            
            
            $inputFilter->add(array(
                'name' => 'training_organization',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));

                        
            $inputFilter->add(array(
                'name' => 'date_certificate_issued',
                'required' => FALSE,
            ));

           $inputFilter->add(array(
                'name' => 'training_certificate',
                'required' => FALSE,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name' => 'Comments',
                'required' => FALSE,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                        ),
                    ),
                ),
            ));
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
