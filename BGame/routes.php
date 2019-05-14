<?php
$app->get('/', 'BGame\Controller\HomeController')->setName('HOME');
$app->get('/admin', 'BGame\Controller\AdminController')->setName('ADMIN');
$app->get('/league/{id}', 'BGame\Controller\LeagueController')->setName('LEAGUE');
$app->get('/team/{id}', 'BGame\Controller\TeamController')->setName('TEAM');
$app->get('/player/{id}', 'BGame\Controller\PlayerController')->setName('PLAYER');
$app->get('/match/{id}', 'BGame\Controller\MatchController')->setName('MATCH');
$app->get('/login', 'BGame\Controller\LoginController')->setName('LOGIN');
$app->post('/login', 'BGame\Controller\Login_exController')->setName('LOGIN_EX');
$app->get('/register', 'BGame\Controller\RegisterController')->setName('REGISTER');
$app->post('/register', 'BGame\Controller\Register_exController')->setName('REGISTER_EX');
$app->get('/register-confirm', 'BGame\Controller\Register_confirmController')->setName('REGISTER_CONFIRM');
$app->get('/dashboard', 'BGame\Controller\DashboardController')->setName('DASHBOARD');
$app->post('/logout', 'BGame\Controller\LogoutController')->setName('LOGOUT');
$app->get('/admin/login', 'BGame\Controller\Admin_loginController')->setName('ADMIN_LOGIN');
$app->post('/admin/newseason', 'BGame\Controller\Admin_newseasonController')->setName('ADMIN_NEWSEASON');
$app->get('/admin/{table}', 'BGame\Controller\Admin_tableController')->setName('ADMIN_TABLE');
$app->get('/admin/{table}/{id}', 'BGame\Controller\Admin_recordController')->setName('ADMIN_RECORD');
$app->get('/admin/{table}/new', 'BGame\Controller\Admin_record_newController')->setName('ADMIN_RECORD_NEW');
$app->get('/admin/{table}/edit/{id}', 'BGame\Controller\Admin_record_editController')->setName('ADMIN_RECORD_EDIT');
$app->get('/admin/{table}/delete/{id}', 'BGame\Controller\Admin_record_deleteController')->setName('ADMIN_RECORD_DELETE');
