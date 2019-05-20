<?php

$container['view'] = function ($c) {
  $templatePath = __DIR__ . '/templates/' . $c->settings["templateName"];
  return new Slim\Views\PhpRenderer($templatePath, [
    "router" => $c->router
  ]);
};

$container['app'] = function ($c) {
  return new UserDemo\App($c->settings["templateName"]);
};

$container['db'] = function($c) {
  $db = new UserDemo\DB();
  $db->setupMySql(
    $c->settings['DB']['HOST'],
    $c->settings['DB']['USER'],
    $c->settings['DB']['PASS'],
    $c->settings['DB']['DBNAME']
  );
  return $db;
};

$container['auth'] = function($c) {
  return new UserDemo\Auth($c->db);
};

// -----------------------------------------------------------------------------
// Middleware factories
// -----------------------------------------------------------------------------
$container['UserDemo\Middleware\AppInit'] = function ($c) {
  return new UserDemo\Middleware\AppInit($c->app);
};
// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------
$container['UserDemo\Controller\HomeController'] = function ($c) {
  return new UserDemo\Controller\HomeController($c->view, $c->app);
};

$container['UserDemo\Controller\LoginController'] = function ($c) {
  return new UserDemo\Controller\LoginController($c->view, $c->app);
};

$container['UserDemo\Controller\Login_actionController'] = function ($c) {
  return new UserDemo\Controller\Login_actionController($c->auth, $c->User_by_username_passwordModel, $c->router, $c->app);
};

$container['UserDemo\Controller\RegisterController'] = function ($c) {
  return new UserDemo\Controller\RegisterController($c->view, $c->app);
};

$container['UserDemo\Controller\Register_actionController'] = function ($c) {
  return new UserDemo\Controller\Register_actionController($c->auth, $c->router, $c->app);
};

$container['UserDemo\Controller\Register_confirm_actionController'] = function ($c) {
  return new UserDemo\Controller\Register_confirm_actionController($c->router, $c->app);
};

$container['UserDemo\Controller\UserslistController'] = function ($c) {
  return new UserDemo\Controller\UserslistController($c->view, $c->app);
};

$container['UserDemo\Controller\ProfileController'] = function ($c) {
  return new UserDemo\Controller\ProfileController($c->view, $c->app);
};

$container['UserDemo\Controller\MessageController'] = function ($c) {
  return new UserDemo\Controller\MessageController($c->MessageModel, $c->view, $c->app);
};

$container['UserDemo\Controller\Lost_passwordController'] = function ($c) {
  return new UserDemo\Controller\Lost_passwordController($c->view, $c->app);
};

$container['UserDemo\Controller\Lost_password_actionController'] = function ($c) {
  return new UserDemo\Controller\Lost_password_actionController($c->router, $c->app);
};

$container['UserDemo\Controller\Change_passwordController'] = function ($c) {
  return new UserDemo\Controller\Change_passwordController($c->view, $c->app);
};

$container['UserDemo\Controller\Change_password_actionController'] = function ($c) {
  return new UserDemo\Controller\Change_password_actionController($c->router, $c->app);
};


// -----------------------------------------------------------------------------
// Model factories
// -----------------------------------------------------------------------------
$container['User_by_username_passwordModel'] = function ($c) {
  return new UserDemo\Model\User_by_username_passwordModel($c->db);
};

$container['MessageModel'] = function ($c) {
  return new UserDemo\Model\MessageModel();
};


// -----------------------------------------------------------------------------
// Actions factories
// -----------------------------------------------------------------------------
