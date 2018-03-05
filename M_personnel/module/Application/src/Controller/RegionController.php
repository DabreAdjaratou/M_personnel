<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Region;
use Application\Model\RegionTable;
use Application\Form\RegionForm;
use Zend\Session\Container;

class RegionController extends AbstractActionController {

    private $table;
    private $db;

    public function __construct(RegionTable $table) {
        $this->table = $table;
    }

    public function indexAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action'=>'redirection'));
               $form = new RegionForm();
        $form->get('submit')->setValue('Submit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $region = new Region();
            $form->setInputFilter($region->getInputFilter());
            $form->setData($request->getPost());
            $regionExists = $request->getPost('region_name');
            $nombre= $this->table->regionExists($regionExists);
          
            if ($form->isValid()) {
                if ($nombre==0){
                    $region->exchangeArray($form->getData());
                $this->table->saveRegion($region);
                $container = new Container('alert');
                $container->alertMsg = 'Region added successfully';

                return $this->redirect()->toRoute('region');
                } else {
                    $container = new Container('alert');
                $container->alertMsg = 'This region already Exists!';

                return $this->redirect()->toRoute('region',array('action' => 'index'));
                }
                
            }
        }

        return new ViewModel(array(
            'regions' => $this->table->fetchAll(),
            'form' => $form,
        ));
    }

    public function editAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action'=>'redirection'));
       
        $id = (int) base64_decode($this->params()->fromRoute('id', 0));

        if (!$id) {
            return $this->redirect()->toRoute('region', array(
                        'action' => 'index'
            ));
        }

        try {
            $region = $this->table->getRegion($id);
//            die(print_r($region));
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('region', array(
                        'action' => 'index'
            ));
        }
        $form = new RegionForm();
        $form->bind($region);
        $form->get('submit')->setAttribute('value', 'Update');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($region->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->table->saveRegion($region);
                $container = new Container('alert');
                $container->alertMsg = 'Region updated successfully';
                return $this->redirect()->toRoute('region');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'regions' => $this->table->fetchAll(),
        );
    }

    public function deleteAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action'=>'redirection'));
       
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('region');
        } else {
            $forein_key = $this->table->foreigne_key($id);
            if ($forein_key == 0) {
                $this->table->deleteRegion($id);
                $container = new Container('alert');
                $container->alertMsg = 'Deleted successfully';
                return $this->redirect()->toRoute('region');
            } else {
                $container = new Container('alert');
                $container->alertMsg = 'Unable to delete this region because it is used for one or more district(s).';
                return $this->redirect()->toRoute('region');
            }
        }
    }
    
    public function districtAction() {
$this->forward()->dispatch('Application\Controller\UserController', array('action'=>'redirection'));
       
        $q = (int) $_GET['q'];
        $result = $this->table->getDistrict($q);
        return array(
            'result' => $result,
        );
    }

}
