<?php
$app->get('/', 'BGame\Controller\HomeController')->setName('HOME');
$app->get('/league/{id}', 'BGame\Controller\LeagueController')->setName('LEAGUE');
$app->get('/team/{id}', 'BGame\Controller\TeamController')->setName('TEAM');
$app->get('/player/{id}', 'BGame\Controller\PlayerController')->setName('PLAYER');
$app->get('/match/{id}', 'BGame\Controller\MatchController')->setName('MATCH');
$app->get('/login', 'BGame\Controller\LoginController')->setName('LOGIN');
$app->post('/login', 'BGame\Controller\Login_exController')->setName('LOGIN_EX');
$app->get('/register', 'BGame\Controller\RegisterController')->setName('REGISTER');
$app->post('/register', 'BGame\Controller\Register_exController')->setName('REGISTER_EX');
$app->get('/register-confirm-ex', 'BGame\Controller\Register_confirm_exController')->setName('REGISTER_CONFIRM_EX');
$app->get('/dashboard', 'BGame\Controller\DashboardController')->setName('DASHBOARD');
$app->post('/logout', 'BGame\Controller\LogoutController')->setName('LOGOUT');
$app->get('/admin', 'BGame\Controller\AdminController')->setName('ADMIN');
$app->get('/admin/message', 'BGame\Controller\Admin_messageController')->setName('ADMIN_MESSAGE');
$app->post('/admin/newseason', 'BGame\Controller\Admin_newseasonController')->setName('ADMIN_NEWSEASON');
$app->get('/admin/create-players', 'BGame\Controller\Admin_create_playersController')->setName('ADMIN_CREATE_PLAYERS');
$app->post('/admin/create-players', 'BGame\Controller\Admin_create_players_exController')->setName('ADMIN_CREATE_PLAYERS_EX');
$app->get('/admin/schedule-match-ex', 'BGame\Controller\Admin_schedule_matchController')->setName('ADMIN_SCHEDULE_MATCH');
$app->get('/admin/schedule-competition', 'BGame\Controller\Admin_schedule_competitionController')->setName('ADMIN_SCHEDULE_COMPETITION');
$app->get('/admin/{table}', 'BGame\Controller\Admin_tableController')->setName('ADMIN_TABLE');
$app->get('/admin/{table}/{id}', 'BGame\Controller\Admin_recordController')->setName('ADMIN_RECORD');
$app->get('/admin/{table}/new', 'BGame\Controller\Admin_record_newController')->setName('ADMIN_RECORD_NEW');
$app->get('/admin/{table}/edit/{id}', 'BGame\Controller\Admin_record_editController')->setName('ADMIN_RECORD_EDIT');
$app->get('/admin/{table}/delete/{id}', 'BGame\Controller\Admin_record_deleteController')->setName('ADMIN_RECORD_DELETE');
