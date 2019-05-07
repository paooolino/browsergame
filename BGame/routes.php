<?php
$app->get('/', 'BGame\Controller\HomeController')->setName('HOME');
$app->get('/login', 'BGame\Controller\LoginController')->setName('LOGIN');
$app->get('/admin', 'BGame\Controller\AdminController')->setName('ADMIN');
$app->get('/logout', 'BGame\Controller\LogoutController')->setName('LOGOUT');
