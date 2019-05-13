<?php

$container['view'] = function ($c) {
  $templatePath = __DIR__ . '/templates/' . $c->settings["templateName"];
  return new Slim\Views\PhpRenderer($templatePath, [
    "router" => $c->router
  ]);
};

$container['app'] = function ($c) {
  return new BGame\App($c->settings["templateName"]);
};

$container['db'] = function($c) {
  $db = new BGame\DB();
  $db->setupMySql(
    $c->settings['DB']['HOST'],
    $c->settings['DB']['USER'],
    $c->settings['DB']['PASS'],
    $c->settings['DB']['DBNAME']
  );
  return $db;
};
// -----------------------------------------------------------------------------
// Middleware factories
// -----------------------------------------------------------------------------
$container['BGame\Middleware\AppInit'] = function ($c) {
  return new BGame\Middleware\AppInit($c->app);
};

$container['BGame\Middleware\Auth'] = function ($c) {
  return new BGame\Middleware\Auth($c->app);
};
// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------
$container['BGame\Controller\HomeController'] = function ($c) {
  return new BGame\Controller\HomeController($c->view, $c->app, $c->LeagueslistModel);
};

$container['BGame\Controller\LoginController'] = function ($c) {
  return new BGame\Controller\LoginController($c->view, $c->app, $c->LeagueslistModel);
};

$container['BGame\Controller\Login_exController'] = function ($c) {
  return new BGame\Controller\Login_exController($c->router, $c->app);
};

$container['BGame\Controller\DashboardController'] = function ($c) {
  return new BGame\Controller\DashboardController($c->view, $c->app);
};

$container['BGame\Controller\AdminController'] = function ($c) {
  return new BGame\Controller\AdminController($c->view);
};

$container['BGame\Controller\LogoutController'] = function ($c) {
  return new BGame\Controller\LogoutController();
};

$container['BGame\Controller\LeagueController'] = function ($c) {
  return new BGame\Controller\LeagueController($c->view, $c->app, $c->LeagueslistModel, $c->LeagueinfosModel);
};

$container['BGame\Controller\TeamController'] = function ($c) {
  return new BGame\Controller\TeamController($c->view, $c->app, $c->LeagueslistModel, $c->TeaminfosModel);
};


// -----------------------------------------------------------------------------
// Model factories
// -----------------------------------------------------------------------------
$container['LeagueslistModel'] = function ($c) {
  return new BGame\Model\LeagueslistModel($c->db);
};

$container['LeagueinfosModel'] = function ($c) {
  return new BGame\Model\LeagueinfosModel($c->db);
};

$container['TeaminfosModel'] = function ($c) {
  return new BGame\Model\TeaminfosModel($c->db);
};


// -----------------------------------------------------------------------------
// Actions factories
// -----------------------------------------------------------------------------
