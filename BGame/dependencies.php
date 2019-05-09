<?php

$container['view'] = function ($c) {
  $templatePath = __DIR__ . '/templates/' . $c->settings["templateName"];
  return new Slim\Views\PhpRenderer($templatePath);
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
  return new BGame\Middleware\Auth();
};
// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------
$container['BGame\Controller\HomeController'] = function ($c) {
  return new BGame\Controller\HomeController($c->view, $c->app);
};

$container['BGame\Controller\LoginController'] = function ($c) {
  return new BGame\Controller\LoginController();
};

$container['BGame\Controller\AdminController'] = function ($c) {
  return new BGame\Controller\AdminController($c->view);
};

$container['BGame\Controller\LogoutController'] = function ($c) {
  return new BGame\Controller\LogoutController();
};


// -----------------------------------------------------------------------------
// Model factories
// -----------------------------------------------------------------------------

// -----------------------------------------------------------------------------
// Actions factories
// -----------------------------------------------------------------------------
