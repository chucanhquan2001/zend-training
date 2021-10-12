<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $userTopic = new Application_Model_UserMapper();
        $data = $userTopic->fetchAll();
        $page = $this->_getParam('page');
        // $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($data));
        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber($page); //This is current page
        $paginator->setItemCountPerPage(3); //Total number of records per page

        //  $this->view->blogTopics = $blogTopic->fetchAllTopics();
        $this->view->paginator = $paginator;

        // For meta title.
        $this->view->title = 'View users';
    }

    public function createAction()
    {
        $formUser = new Application_Form_User();
        $request = new Zend_Controller_Request_Http();
        if ($request->isPost()) {
            if ($formUser->isValid($request->getPost())) {
                $data = new Application_Model_User($formUser->getValues());
                $mapper  = new Application_Model_UserMapper();
                $mapper->save($data);
                return $this->_helper->redirector('index');
            }
        }
        $this->view->userForm = $formUser;
    }

    public function editAction()
    {
        $userEditForm = new Application_Form_UserEdit();
        $userEditForm->email->addValidator(new Zend_Validate_Db_NoRecordExists(
            array(
                'table' => 'users',
                'field' => 'email',
                'exclude' => array(
                    'field' => 'id',
                    'value' => 21
                )
            )
        ));
        $request = new Zend_Controller_Request_Http();
        $data = new Application_Model_User($userEditForm->getValues());
        $mapper  = new Application_Model_UserMapper();

        if ($request->isGet()) {
            $id = $this->getRequest()->getParam('id');
            $edit = $mapper->find($id, $data);
            $this->view->userEditForm = $userEditForm->populate($edit->toArray());
        }
        if ($request->isPost()) {

            if ($userEditForm->isValid($request->getPost())) {
                $mapper->saveEdit($data);
                return $this->_helper->redirector('index');
            } else {
                $id = $this->getRequest()->getParam('id');
                $edit = $mapper->find($id, $data);
                $this->view->userEditForm = $userEditForm->populate($edit->toArray());
            }
        }
    }

    public function updateAction()
    {
    }

    public function deleteAction()
    {
        $request = new Zend_Controller_Request_Http();
        if ($request->isGet()) {
            $id = $this->getRequest()->getParam('id');
            $mapper = new Application_Model_UserMapper();
            $mapper->delete($id);
            $this->redirect('/user');
        }
    }

    public function softDeleteAction()
    {
        // action body
    }

    public function garbageAction()
    {
        // action body
    }
}
