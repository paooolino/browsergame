<?php
// DIC configuration

$container = $app->getContainer();

$container['view'] = function ($c) {
  $templatePath = __DIR__ . '/../templates/'
    . $c->settings['templateName'];
  return new Slim\Views\PhpRenderer($templatePath, [
    "router" => $c->router
  ]);
};

$container['app'] = function ($c) {
  return new BGame\App();
};

// middleware factories

$container['BGame\Middleware\AppInit'] = function ($c) {
  return new BGame\Middleware\AppInit($c->app);
};

$container['BGame\Controller\Home'] = function ($c) {
  return new BGame\Controller\Home($c->view, $c->app);
};

$container['BGame\Controller\Register'] = function ($c) {
  return new BGame\Controller\Register($c->view, $c->app);
};

$container['BGame\Controller\Register_post'] = function ($c) {
  return new BGame\Controller\Register_post($c->view, $c->app);
};

$container['BGame\Controller\RegisterConfirm'] = function ($c) {
  return new BGame\Controller\RegisterConfirm($c->view, $c->app);
};

$container['BGame\Controller\Login'] = function ($c) {
  return new BGame\Controller\Login($c->view, $c->app);
};

$container['BGame\Controller\Login_post'] = function ($c) {
  return new BGame\Controller\Login_post($c->view, $c->app);
};

$container['BGame\Controller\LostPassword'] = function ($c) {
  return new BGame\Controller\LostPassword($c->view, $c->app);
};

$container['BGame\Controller\LostPassword_post'] = function ($c) {
  return new BGame\Controller\LostPassword_post($c->view, $c->app);
};

$container['BGame\Controller\Manager'] = function ($c) {
  return new BGame\Controller\Manager($c->view, $c->app);
};

$container['BGame\Controller\Team'] = function ($c) {
  return new BGame\Controller\Team($c->view, $c->app);
};

$container['BGame\Controller\Player'] = function ($c) {
  return new BGame\Controller\Player($c->view, $c->app);
};

$container['BGame\Controller\Competition'] = function ($c) {
  return new BGame\Controller\Competition($c->view, $c->app);
};

$container['BGame\Controller\CompetitionLevel'] = function ($c) {
  return new BGame\Controller\CompetitionLevel($c->view, $c->app);
};

$container['BGame\Controller\CompetitionLeague'] = function ($c) {
  return new BGame\Controller\CompetitionLeague($c->view, $c->app);
};

$container['BGame\Controller\CompetitionCalendar'] = function ($c) {
  return new BGame\Controller\CompetitionCalendar($c->view, $c->app);
};

$container['BGame\Controller\CompetitionStandings'] = function ($c) {
  return new BGame\Controller\CompetitionStandings($c->view, $c->app);
};

$container['BGame\Controller\Match'] = function ($c) {
  return new BGame\Controller\Match($c->view, $c->app);
};

$container['BGame\Controller\UserManager'] = function ($c) {
  return new BGame\Controller\UserManager($c->view, $c->app);
};

$container['BGame\Controller\UserTraining'] = function ($c) {
  return new BGame\Controller\UserTraining($c->view, $c->app);
};

$container['BGame\Controller\UserMatchSettings'] = function ($c) {
  return new BGame\Controller\UserMatchSettings($c->view, $c->app);
};

$container['BGame\Controller\UserTeam'] = function ($c) {
  return new BGame\Controller\UserTeam($c->view, $c->app);
};

$container['BGame\Controller\UserCompetition'] = function ($c) {
  return new BGame\Controller\UserCompetition($c->view, $c->app);
};

$container['BGame\Controller\UserLevel'] = function ($c) {
  return new BGame\Controller\UserLevel($c->view, $c->app);
};

$container['BGame\Controller\UserLeague'] = function ($c) {
  return new BGame\Controller\UserLeague($c->view, $c->app);
};

$container['BGame\Controller\UserCalendar'] = function ($c) {
  return new BGame\Controller\UserCalendar($c->view, $c->app);
};

$container['BGame\Controller\UserStandings'] = function ($c) {
  return new BGame\Controller\UserStandings($c->view, $c->app);
};

