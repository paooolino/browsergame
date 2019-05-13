<?php
$app->get('/', 'BGame\Controller\HomeController')->setName('HOME');
$app->get('/login', 'BGame\Controller\LoginController')->setName('LOGIN');
$app->post('/login', 'BGame\Controller\Login_exController')->setName('LOGIN_EX');
$app->get('/dashboard', 'BGame\Controller\DashboardController')->setName('DASHBOARD');
$app->get('/admin', 'BGame\Controller\AdminController')->setName('ADMIN');
$app->post('/logout', 'BGame\Controller\LogoutController')->setName('LOGOUT');
$app->get('/league/{url}', 'BGame\Controller\LeagueController')->setName('LEAGUE');
$app->get('/team/{id}', 'BGame\Controller\TeamController')->setName('TEAM');
