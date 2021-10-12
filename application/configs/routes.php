<?php

$route = new Zend_Controller_Router_Route(
    'user',
    array(
        'controller' => 'user',
        'action'     => 'index'
    )
);
$router->addRoute('user', $route);

$route = new Zend_Controller_Router_Route(
    'user/create', array(
        'controller' => 'user',
        'action' => 'create'
    )
);
$router->addRoute('user/create', $route);

$route = new Zend_Controller_Router_Route(
    'user/edit/:id', array(
        'controller' => 'user',
        'action' => 'edit'
    ), array('id' => '\d+')
);
$router->addRoute('user/edit/:id', $route);

$route = new Zend_Controller_Router_Route(
    'user/delete/:id', array(
        'controller' => 'user',
        'action' => 'delete'
    ), array('id' => '\d+')
);
$router->addRoute('user/delete/:id', $route);