<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\District;
use Application\Model\DistrictTable;
use Application\Form\DistrictForm;
use Zend\Session\Container;

class DistrictController extends AbstractActionController {

    private $table;
    private $db;

    public function __construct(\Application\Model\DistrictTable $table) {
        $this->table = $table;
    }

    public function indexAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action'=>'redirection'));
       
        $form = new DistrictForm();
        $form->get('submit')->setValue('Submit');
        $request = $this->getRequest();

        if ($request->isPost()) {
            $district = new District();
            $form->setInputFilter($district->getInputFilter());
            $form->setData($request->getPost());
            $districtExists = $request->getPost('district_name');
            $region = $request->getPost('region');
            $nombre = $this->table->ditrictExists($districtExists,$region);

            if ($form->isValid()) {
                if ($nombre == 0) {
                    $district->exchangeArray($form->getData());
                    $this->table->saveDistrict($district);
                    $container = new Container('alert');
                    $container->alertMsg = 'District added successfully';
                    return $this->redirect()->toRoute('district');
                } else {
                    $container = new Container('alert');
                    $container->alertMsg = 'This district already Exists!';

                    return $this->redirect()->toRoute('district', array('action' => 'index'));
                }
            }
        }
        return new ViewModel(array(
            'districts' => $this->table->fetchAll(),
            'form' => $form,
            'regions' => $this->table->getRegion(),
        ));
    }

    public function editAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action'=>'redirection'));
       
        $id = (int) base64_decode($this->params()->fromRoute('id', 0));
        if (!$id) {
            return $this->redirect()->toRoute('district', array(
                        'action' => 'index'
            ));
        }

        try {
            $district = $this->table->getDistrict($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('district', array(
                        'action' => 'index'
            ));
        }

        $form = new DistrictForm();
        $form->bind($district);
        $form->get('submit')->setAttribute('value', 'Update');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($district->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->table->saveDistrict($district);
                $container = new Container('alert');
                $container->alertMsg = 'District updated successfully';
                return $this->redirect()->toRoute('district');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'regions' => $this->table->getRegion(),
        );
    }

    public function deleteAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action'=>'redirection'));
       
        $id = (int) base64_decode($this->params()->fromRoute('id', 0));

        if (!$id) {
            return $this->redirect()->toRoute('district');
        } else {

            $this->table->deleteDistrict($id);
            $container = new Container('alert');
            $container->alertMsg = 'Deleted successfully';
            return $this->redirect()->toRoute('district');
        }
    }

}
