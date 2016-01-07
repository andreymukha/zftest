<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction(){
        $request = $this->getRequest();

        $form = new Application_Form_Index();

        $sort = new Application_Form_Sort();

        $messages = new Application_Model_DbTable_Message();
        $users = new Application_Model_DbTable_User();
        if($request->isPost()){
            if(isset($request->getPost()['submit2'])){
                $yandex = new Application_Model_YandexReferat();

                $message['name'] = 'Иван';
                $message['email'] = 'ivan@mail.ru';
                $message['title'] = $yandex->yandex_referat()['title'];
                $message['text'] = $yandex->yandex_referat()['body'];

                $user = $users->getUser(NULL, $message['email']);

                if(empty($user)){
                    $userAgent = new Zend_Http_UserAgent();
                    $user_id = $users->addUser($message['name'], $message['email'], $userAgent->getDevice()->getUserAgent());
                }else{
                    $user_id = $user['user_id'];
                }
                $messages->addMessage($user_id, $message['title'], $message['text']);
                $this->_helper->redirector('index');
            }else{
                if($form->isValid($request->getPost())){
                    $messages = new Application_Model_DbTable_Message();
                    $users = new Application_Model_DbTable_User();
                    $message = $form->getValues();
                    $user = $users->getUser(NULL, $message['email']);

                    if(empty($user)){
                        $userAgent = new Zend_Http_UserAgent();
                        $user_id = $users->addUser($message['name'], $message['email'], $userAgent->getDevice()->getUserAgent());
                    }else{
                        $user_id = $user['user_id'];
                    }

                    $messages->addMessage($user_id, $message['title'], $message['text']);
                    $this->_helper->redirector('index');
                }
            }
        }

        $this->view->form = $form;

        $this->view->sort = $sort;

        if(isset($request->getQuery()['sort'])){
            $sortable = $request->getQuery();
            $sort->populate(array('sortby' => $sortable['sortby'], 'orderby' => $sortable['orderby']));

        }else{
            $sortable['sortby'] = 'message_id';
            $sortable['orderby'] = 'ASC';
        }

        $page_messages = $messages->getMessages($sortable);

        $paginator = Zend_Paginator::factory($page_messages);

        $page = $this->_getParam('page', 1);

        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(5);

        $this->view->messages = $paginator;
    }
}

