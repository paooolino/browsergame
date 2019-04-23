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

$container['BGame\Controller\Home'] = function ($c) {
  return new BGame\Controller\Home($c->view);
};

$container['BGame\Controller\Register'] = function ($c) {
  return new BGame\Controller\Register($c->view);
};

$container['BGame\Controller\Register_post'] = function ($c) {
  return new BGame\Controller\Register_post($c->view);
};

$container['BGame\Controller\RegisterConfirm'] = function ($c) {
  return new BGame\Controller\RegisterConfirm($c->view);
};

$container['BGame\Controller\Login'] = function ($c) {
  return new BGame\Controller\Login($c->view);
};

$container['BGame\Controller\Login_post'] = function ($c) {
  return new BGame\Controller\Login_post($c->view);
};

$container['BGame\Controller\LostPassword'] = function ($c) {
  return new BGame\Controller\LostPassword($c->view);
};

$container['BGame\Controller\LostPassword_post'] = function ($c) {
  return new BGame\Controller\LostPassword_post($c->view);
};

$container['BGame\Controller\Manager'] = function ($c) {
  return new BGame\Controller\Manager($c->view);
};

$container['BGame\Controller\Team'] = function ($c) {
  return new BGame\Controller\Team($c->view);
};

$container['BGame\Controller\Player'] = function ($c) {
  return new BGame\Controller\Player($c->view);
};

$container['BGame\Controller\Competition'] = function ($c) {
  return new BGame\Controller\Competition($c->view);
};

$container['BGame\Controller\CompetitionLevel'] = function ($c) {
  return new BGame\Controller\CompetitionLevel($c->view);
};

$container['BGame\Controller\CompetitionLeague'] = function ($c) {
  return new BGame\Controller\CompetitionLeague($c->view);
};

$container['BGame\Controller\CompetitionCalendar'] = function ($c) {
  return new BGame\Controller\CompetitionCalendar($c->view);
};

$container['BGame\Controller\CompetitionStandings'] = function ($c) {
  return new BGame\Controller\CompetitionStandings($c->view);
};

$container['BGame\Controller\Match'] = function ($c) {
  return new BGame\Controller\Match($c->view);
};

$container['BGame\Controller\UserManager'] = function ($c) {
  return new BGame\Controller\UserManager($c->view);
};

$container['BGame\Controller\UserTraining'] = function ($c) {
  return new BGame\Controller\UserTraining($c->view);
};

$container['BGame\Controller\UserMatchSettings'] = function ($c) {
  return new BGame\Controller\UserMatchSettings($c->view);
};

$container['BGame\Controller\UserTeam'] = function ($c) {
  return new BGame\Controller\UserTeam($c->view);
};

$container['BGame\Controller\UserCompetition'] = function ($c) {
  return new BGame\Controller\UserCompetition($c->view);
};

$container['BGame\Controller\UserLevel'] = function ($c) {
  return new BGame\Controller\UserLevel($c->view);
};

$container['BGame\Controller\UserLeague'] = function ($c) {
  return new BGame\Controller\UserLeague($c->view);
};

$container['BGame\Controller\UserCalendar'] = function ($c) {
  return new BGame\Controller\UserCalendar($c->view);
};

$container['BGame\Controller\UserStandings'] = function ($c) {
  return new BGame\Controller\UserStandings($c->view);
};

