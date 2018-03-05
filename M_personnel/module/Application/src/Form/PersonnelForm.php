<?php

namespace Application\Form;

use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;

class PersonnelForm extends Form {

    public function __construct() {

        // we want to ignore the name passed
        parent::__construct('personnel');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'last_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Last Name (Surname)',
            ),
        ));
        $this->add(array(
            'name' => 'first_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'First Name',
            ),
        ));

        $this->add(array(
            'name' => 'middle_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Middle Name (3rd name)',
            ),
        ));
        $this->add(array(
            'name' => 'phone',
            'type' => 'text',
            'options' => array(
                'label' => 'Phone',
            ),
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
        ));
        $this->add(array(
            'name' => 'region',
            'type' => 'select',
            'options' => array(
                'label' => 'Region',
                'empty_option' => 'Please choose a region',
                'disable_inarray_validator' => true,
            ),
        ));
        $this->add(array(
            'name' => 'district',
            'type' => 'Select',
            'options' => array(
                'label' => 'District',
                'empty_option' => 'Please choose a district',
                'disable_inarray_validator' => true,
            ),
        ));

        $this->add(array(
            'name' => 'affiliation',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Affiliation',
                'empty_option' => 'Please Choose An Affiliation',
                'value_options' => array(
                    'Auditor' => 'Auditor',
                    'Assesor' => 'Assesor',
                ),
            ),
        ));


        $this->add(array(
            'name' => 'current_jod',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Current Job Title',
                'empty_option' => 'Please Choose A Job Title',
                'value_options' => array(
                    'Assistant Medical Officer' => 'Assistant Medical Officer',
                    'Counselor' => 'Counselor',
                    'Health assistant' => 'Health assistant',
                    'Health attendant' => 'Health attendant',
                    'Lab Assistant' => 'Lab Assistant',
                    'Lab Scientist' => 'Lab Scientist',
                    'Lab technician' => 'Lab technician',
                    'Lab technologist' => 'Lab technologist',
                    'Medical doctor' => 'Medical doctor',
                    'Midwife' => 'Midwife',
                    'Nurse' => 'Nurse',
                    'Nurse assistant' => 'Nurse assistant'
                ),
            ),
        ));

        $this->add(array(
            'name' => 'time_worked',
            'type' => 'Number',
            'options' => array(
                'label' => 'Time Worked As Auditor/Assesor',
            ),
            'attributes' => [
                'min' => '1',
                'step' => '1', // default step interval is 1
            ],
        ));

$this->add(array(
            'type' => 'text',
            'name' => 'last_training_date',
            'attributes' => [
                'id' => 'date',
                'type' => 'text'
            ],
            'options' => array(
                'label' => 'Date of Last Training/Activity'
            )
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'type_of_training',
            'options' => array(
                'label' => 'Type of Activity/Training',
                'empty_option' => 'Please choose a Type of Training',
                'value_options' => array(
                    'Initial training (Nationally approved RT training)' => 'Initial  training (Nationally approved RT training)',
                    'Initial  training (on the job training by peer)' => 'Initial  training (on the job training by peer)',
                    'In-service training (on job by supervisor)' => 'In-service training (on job by supervisor)',
                    'In-service training (nationally approved)' => 'In-service training (nationally approved)',
                    'In-service training (distance learning, i.e., ECHO)' => 'In-service training (distance learning, i.e., ECHO)',
                    'Mentoring (on job by supervisor)' => 'Mentoring (on job by supervisor)',
                    'Mentoring (Distance learning, i.e., ECHO)' => 'Mentoring (Distance learning, i.e., ECHO',
                    'Refresher training (Nationally approved RT training)' => 'Refresher training (Nationally approved RT training)',
                    'Refresher training (Topic specific training)' => 'Refresher training (Topic specific training)',
                    'Regional workshop' => 'Regional workshop',
                ),
            ),
        ));

        $this->add(array(
            'type' => 'Number',
            'name' => 'length_of_training',
            'options' => array(
                'label' => 'Length of Activity/Training',
            ),
            'attributes' => [
                'min' => '1',
                'step' => '1', // default step interval is 1
            ],
        ));
        $this->add(array(
            'type' => 'text',
            'name' => 'training_organization',
            'options' => array(
                'label' => 'Training Organization',
                )
        ));

       

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'training_certificate',
            'options' => array(
                'label' => 'Training certificate (if available)',
                'empty_option' => 'Please choose a training certificate',
                'value_options' => array(
                    'Yes' => 'Yes',
                    'No' => 'No',
                ),
            ),
        ));



        $this->add(array(
            'type' => 'text',
            'name' => 'date_certificate_issued',
            'attributes' => [
                'id' => 'date2',
                'type' => 'text'
            ],
            'options' => array(
                'label' => 'Date certificate issued (if available)'
            )
        ));

        $this->add(array(
            'name' => 'Comments',
            'attributes' => array(
                'type' => 'textarea'
            ),
            'options' => array(
                'label' => 'Comments',
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
