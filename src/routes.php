<?php
  $app->get('/', 'BGame\Controller\Home')->setName('HOME');
  $app->get('/register', 'BGame\Controller\Register')->setName('REGISTER');
  $app->post('/register', 'BGame\Controller\Register_post')->setName('REGISTER:POST');
  $app->get('/register-confirm', 'BGame\Controller\RegisterConfirm')->setName('REGISTER_CONFIRM');
  $app->get('/login', 'BGame\Controller\Login')->setName('LOGIN');
  $app->post('/login', 'BGame\Controller\Login_post')->setName('LOGIN:POST');
  $app->get('/lost-password', 'BGame\Controller\LostPassword')->setName('LOST_PASSWORD');
  $app->post('/lost-password', 'BGame\Controller\LostPassword_post')->setName('LOST_PASSWORD:POST');
  $app->get('/manager/{id}', 'BGame\Controller\Manager')->setName('MANAGER');
  $app->get('/team/{id}', 'BGame\Controller\Team')->setName('TEAM');
  $app->get('/player/{id}', 'BGame\Controller\Player')->setName('PLAYER');
  $app->get('/competition/{id}', 'BGame\Controller\Competition')->setName('COMPETITION');
  $app->get('/competition/{id}/{level}', 'BGame\Controller\CompetitionLevel')->setName('COMPETITION_LEVEL');
  $app->get('/competition/{id}/{level}/{league}', 'BGame\Controller\CompetitionLeague')->setName('COMPETITION_LEAGUE');
  $app->get('/competition/{id}/{level}/{league}/calendar[/{day}]', 'BGame\Controller\CompetitionCalendar')->setName('COMPETITION_CALENDAR');
  $app->get('/competition/{id}/{level}/{league}/standings', 'BGame\Controller\CompetitionStandings')->setName('COMPETITION_STANDINGS');
  $app->get('/match/{id}', 'BGame\Controller\Match')->setName('MATCH');
  $app->get('/manager', 'BGame\Controller\UserManager')->setName('USER_MANAGER');
  $app->get('/training', 'BGame\Controller\UserTraining')->setName('USER_TRAINING');
  $app->get('/match-settings', 'BGame\Controller\UserMatchSettings')->setName('USER_MATCH_SETTINGS');
  $app->get('/team', 'BGame\Controller\UserTeam')->setName('USER_TEAM');
  $app->get('/competition', 'BGame\Controller\UserCompetition')->setName('USER_COMPETITION');
  $app->get('/level', 'BGame\Controller\UserLevel')->setName('USER_LEVEL');
  $app->get('/league', 'BGame\Controller\UserLeague')->setName('USER_LEAGUE');
  $app->get('/calendar', 'BGame\Controller\UserCalendar')->setName('USER_CALENDAR');
  $app->get('/standings', 'BGame\Controller\UserStandings')->setName('USER_STANDINGS');

  