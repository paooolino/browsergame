<?php

$container['view'] = function ($c) {
  $templatePath = __DIR__ . '/templates/' . $c->settings["templateName"];
  return new Slim\Views\PhpRenderer($templatePath);
};

$container['app'] = function ($c) {
  return new NS\App();
};

$container['db'] = function($c) {
  $db = new NS\DB();
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

$container['NS\Middleware\AppInit'] = function ($c) {
  return new NS\Middleware\AppInit($c->app);
};

$container['NS\Middleware\Auth'] = function ($c) {
  return new NS\Middleware\Auth();
};

// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------

$container['NS\Controller\HomeController'] = function ($c) {
  return new NS\Controller\HomeController($c->view, $c->app);
};

$container['NS\Controller\LoginController'] = function ($c) {
  return new NS\Controller\LoginController();
};

$container['NS\Controller\AdminController'] = function ($c) {
  return new NS\Controller\AdminController();
};

$container['NS\Controller\LogoutController'] = function ($c) {
  return new NS\Controller\LogoutController();
};

// -----------------------------------------------------------------------------
// Model factories
// -----------------------------------------------------------------------------

$container['NS\Model\List'] = function ($c) {
  return new NS\Model\UsersList();
};

// -----------------------------------------------------------------------------
// Actions factories
// -----------------------------------------------------------------------------

$container['NS\Action\Login'] = function ($c) {
  return new NS\Action\Login();
};

$container['NS\Action\Logout'] = function ($c) {
  return new NS\Action\Logout();
};
