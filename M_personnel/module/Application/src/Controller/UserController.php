<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Model\UserTable;
use Zend\View\Model\ViewModel;
use Application\Form\UserForm;
use Application\Model\User;
use Zend\Session\Container;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

class UserController extends AbstractActionController {

    private $table;
    private $db;

    public function __construct(UserTable $table) {
        $this->table = $table;
    }

    public function indexAction() {
        $this->redirectionAction();
        return new ViewModel([
            'users' => $this->table->fetchAll(),
        ]);
    }

    public function addAction() {
        $this->redirectionAction();
        $form = new UserForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        $roles = $this->table->getRoles();

        if (!$request->isPost()) {
            return ['form' => $form,
                'roles' => $roles,];
        }
//
        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form,
                'roles' => $roles];
        }

        $user->exchangeArray($form->getData());
        $login = $request->getPost('login');
        $password = $request->getPost('password');
        $confirm_password = $request->getPost('confirm-password');
        $login_info = $this->table->login($login);
        if (!empty($login_info)) {
            $container = new Container('alert');
            $container->alertMsg = "this login is already used. please choose another!";
            return['form' => $form,
                'roles' => $roles,
            ];
        }

        if ($password != $confirm_password) {
            $container = new Container('alert');
            $container->alertMsg = "the two passwords don\'t match";
            return['form' => $form,
                'roles' => $roles,
            ];
        } else {
            $this->table->saveUser($user);
            $container = new Container('alert');
            $container->alertMsg = 'added successfully';
            return $this->redirect()->toRoute('user');
        }
    }

    public function updateAction() {

        $this->redirectionAction();
        $id = (int) base64_decode($this->params()->fromRoute('id', 0));

        if (0 === $id) {
            return $this->redirect()->toRoute('user', ['action' => 'add']);
        }


        try {
            $user = $this->table->getUser($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }
        $roles = $this->table->getRoles();
        $form = new UserForm();
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Update');
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form, 'roles' => $roles];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return $viewData;
        }
        $login = $request->getPost('login');
        $password = $request->getPost('password');
        $confirm_password = $request->getPost('confirm-password');
        $login_info = $this->table->login($login);

        if (empty($login_info) || (!empty($login_info) && $id == (int) $login_info['id'])) {

            if ($password != $confirm_password) {
                $container = new Container('alert');
                $container->alertMsg = "the two passwords don\'t match";
                return['form' => $form,
                    'roles' => $roles,
                ];
            } else {

                $this->table->saveUser($user);
                $container = new Container('alert');
                $container->alertMsg = 'Updated successfully';
                return $this->redirect()->toRoute('user', ['action' => 'index']);
            }
        } else {
            $container = new Container('alert');
            $container->alertMsg = "this login is already used. please choose another!";
            return['form' => $form,
                'roles' => $roles,];
        }
    }

    public function deleteAction() {
        $this->redirectionAction();

        $id = (int) base64_decode($this->params()->fromRoute('id', 0));
        if (!$id) {
            return $this->redirect()->toRoute('user');
        }

        $this->table->deleteUser($id);
        $container = new Container('alert');
        $container->alertMsg = 'Deleted successfully';
        return $this->redirect()->toRoute('user');
    }

    public function loginAction() {

        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $login = $_POST['user'];
            $pass = $_POST['pass'];
            $login_info = $this->table->login($login);

            $this->aclAction();
            if (!empty($login_info)) {

                if (password_verify($pass, $login_info['password']) && $login_info['status'] == 'active') {
                    $role = $login_info['role'];
                    $user_session = new Container('user');
                    $user_session->user = $login_info['id'];
                    $user_session->role = $role;
//                   
                    return $this->redirect()->toRoute('personnel', array('action' => 'index'));
//               
                } else {
                    $container = new Container('alert');
                    $container->alertMsg = 'Invalid login credential';
//               
                }
            } else {
                $container = new Container('alert');
                $container->alertMsg = 'Invalid login credential';
//               
            }
        }

        return $viewModel;
    }

    public function logoutAction() {
        $user_session = new Container('user');
        $user_session->getManager()->getStorage()->clear();
        return $this->redirect()->toRoute('login');
    }

    public function redirectionAction() {
        $user_session = new Container('user');
        $user= $user_session->user;
        if (!isset($user)) {
            $this->redirect()->toRoute('login');
        }
    }

    public function aclAction() {
        $acl = new Acl();
        $roles = $this->table->getRoles();
        foreach ($roles as $role) {
            $acl->addRole(new Role($role['name']));
        }

        $ressources = $this->table->getRessources();
        foreach ($ressources as $ressource) {

            $acl->addResource(new Resource(trim($ressource['ressource_name'])));
        }

        $privileges = $this->table->getPrivileges();
        foreach ($privileges as $privilege) {
          
            $acl->allow($privilege['role_name'], $privilege['ressource_name'], $privilege['privilege_name']);
        }
        $acl->allow('super admin');
        $acl_container = new Container('acl');
        $acl_container->acl = $acl;
    }

}
