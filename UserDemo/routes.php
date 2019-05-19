<?php
$app->get('/', 'UserDemo\Controller\HomeController')->setName('HOME');
$app->get('/login', 'UserDemo\Controller\LoginController')->setName('LOGIN');
$app->post('/login', 'UserDemo\Controller\Login_actionController')->setName('LOGIN_ACTION');
$app->get('/register', 'UserDemo\Controller\RegisterController')->setName('REGISTER');
$app->post('/register', 'UserDemo\Controller\Register_actionController')->setName('REGISTER_ACTION');
$app->get('/register-confirm', 'UserDemo\Controller\Register_confirm_actionController')->setName('REGISTER_CONFIRM_ACTION');
$app->get('/users-list', 'UserDemo\Controller\UserslistController')->setName('USERSLIST');
$app->get('/profile', 'UserDemo\Controller\ProfileController')->setName('PROFILE');
$app->get('/message', 'UserDemo\Controller\MessageController')->setName('MESSAGE');
$app->get('/lost-password', 'UserDemo\Controller\Lost_passwordController')->setName('LOST_PASSWORD');
$app->post('/lost-password', 'UserDemo\Controller\Lost_password_actionController')->setName('LOST_PASSWORD_ACTION');
$app->get('/change-password', 'UserDemo\Controller\Change_passwordController')->setName('CHANGE_PASSWORD');
$app->post('/change-password', 'UserDemo\Controller\Change_password_actionController')->setName('CHANGE_PASSWORD_ACTION');
