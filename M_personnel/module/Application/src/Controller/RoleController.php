<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Role;
use Application\Model\RoleTable;
use Application\Form\RoleForm;
use Zend\Session\Container;

class RoleController extends AbstractActionController {

    private $table;
    private $db;

    public function __construct(RoleTable $table) {
        $this->table = $table;
    }

    public function indexAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action' => 'redirection'));
        return new ViewModel(array(
            'roles' => $this->table->fetchAll(),
        ));
    }

    public function addAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action' => 'redirection'));
        $form = new RoleForm();
        $form->get('submit')->setValue('Add');
        $ressources = $this->table->ressource();
        $p=[
            'fruit'=>['banane','ananas','mangue'],
            'couleur'=>['rouge','jaune','vert']
        ];
        foreach ($ressources as $ressource){
         $f=$this->table->privilege($ressource);

        }
        print_r($f);die();
      
        $request = $this->getRequest();
        $viewData = ['form' => $form, 'privileges' =>$f, 'ressources'=>$ressources];

        if (!$request->isPost()) {
            return $viewData;
        }

        $role = new Role();
        $form->setInputFilter($role->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }
        $role_name = $request->getPost('name');
        $role_code = $request->getPost('code');
        $nombre = $this->table->roleExists($role_name, $role_code);
        if ($nombre == 0) {
            $role->exchangeArray($form->getData());
            $this->table->saveRole($role);
            $container = new Container('alert');
            $container->alertMsg = 'added successfully';
            return $this->redirect()->toRoute('role');
        } else {
            $container = new Container('alert');
            $container->alertMsg = 'A role with the same code or name already Exists!';

            return $this->redirect()->toRoute('role', array('action' => 'index'));
        }
    }

    public function updateAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action' => 'redirection'));

        $id = (int) base64_decode($this->params()->fromRoute('id', 0));

        if (0 === $id) {
            return $this->redirect()->toRoute('role', ['action' => 'add']);
        }

        try {
            $role = $this->table->getRole($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('role', ['action' => 'index']);
        }

        $form = new RoleForm();
        $form->bind($role);
        $form->get('submit')->setAttribute('value', 'Update');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($role->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }

        $this->table->saveRole($role);
        $container = new Container('alert');
        $container->alertMsg = 'Role updated successfully';
        return $this->redirect()->toRoute('role', ['action' => 'index']);
    }

    public function deleteAction() {
        $this->forward()->dispatch('Application\Controller\UserController', array('action' => 'redirection'));
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('role');
        }

        $this->table->deleteRole($id);
        $container = new Container('alert');
        $container->alertMsg = 'Deleted successfully';
        return $this->redirect()->toRoute('role');
    }

}
