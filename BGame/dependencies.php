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
  return new BGame\Controller\HomeController($c->view, $c->app, $c->LeaguesModel);
};

$container['BGame\Controller\AdminController'] = function ($c) {
  return new BGame\Controller\AdminController($c->view, $c->app);
};

$container['BGame\Controller\LeagueController'] = function ($c) {
  return new BGame\Controller\LeagueController($c->view, $c->app, $c->LeaguesModel, $c->LeagueModel, $c->StandingsModel, $c->FixturesModel);
};

$container['BGame\Controller\TeamController'] = function ($c) {
  return new BGame\Controller\TeamController($c->view, $c->app, $c->LeaguesModel, $c->TeamModel);
};

$container['BGame\Controller\PlayerController'] = function ($c) {
  return new BGame\Controller\PlayerController($c->view, $c->app, $c->LeaguesModel, $c->PlayerModel);
};

$container['BGame\Controller\MatchController'] = function ($c) {
  return new BGame\Controller\MatchController($c->view, $c->app, $c->LeaguesModel, $c->MatchModel);
};

$container['BGame\Controller\LoginController'] = function ($c) {
  return new BGame\Controller\LoginController($c->view, $c->app, $c->LeaguesModel);
};

$container['BGame\Controller\Login_exController'] = function ($c) {
  return new BGame\Controller\Login_exController($c->router, $c->app);
};

$container['BGame\Controller\RegisterController'] = function ($c) {
  return new BGame\Controller\RegisterController($c->view, $c->app, $c->LeaguesModel);
};

$container['BGame\Controller\Register_exController'] = function ($c) {
  return new BGame\Controller\Register_exController($c->router, $c->app);
};

$container['BGame\Controller\Register_confirmController'] = function ($c) {
  return new BGame\Controller\Register_confirmController($c->view, $c->app, $c->LeaguesModel);
};

$container['BGame\Controller\DashboardController'] = function ($c) {
  return new BGame\Controller\DashboardController($c->view, $c->app);
};

$container['BGame\Controller\LogoutController'] = function ($c) {
  return new BGame\Controller\LogoutController();
};

$container['BGame\Controller\Admin_loginController'] = function ($c) {
  return new BGame\Controller\Admin_loginController($c->view, $c->admin, $c->TablesModel);
};

$container['BGame\Controller\Admin_newseasonController'] = function ($c) {
  return new BGame\Controller\Admin_newseasonController($c->router, $c->admin);
};

$container['BGame\Controller\Admin_tableController'] = function ($c) {
  return new BGame\Controller\Admin_tableController($c->view, $c->admin, $c->TableModel);
};

$container['BGame\Controller\Admin_recordController'] = function ($c) {
  return new BGame\Controller\Admin_recordController($c->view, $c->admin, $c->TableModel, $c->RecordModel);
};

$container['BGame\Controller\Admin_record_newController'] = function ($c) {
  return new BGame\Controller\Admin_record_newController($c->view, $c->admin, $c->TableModel);
};

$container['BGame\Controller\Admin_record_editController'] = function ($c) {
  return new BGame\Controller\Admin_record_editController($c->view, $c->admin, $c->TableModel, $c->RecordModel);
};

$container['BGame\Controller\Admin_record_deleteController'] = function ($c) {
  return new BGame\Controller\Admin_record_deleteController($c->view, $c->admin, $c->TableModel, $c->RecordModel);
};


// -----------------------------------------------------------------------------
// Model factories
// -----------------------------------------------------------------------------
$container['LeaguesModel'] = function ($c) {
  return new BGame\Model\LeaguesModel($c->db);
};

$container['LeagueModel'] = function ($c) {
  return new BGame\Model\LeagueModel($c->db);
};

$container['TeamModel'] = function ($c) {
  return new BGame\Model\TeamModel($c->db);
};

$container['PlayerModel'] = function ($c) {
  return new BGame\Model\PlayerModel($c->db);
};

$container['MatchModel'] = function ($c) {
  return new BGame\Model\MatchModel($c->db);
};


// -----------------------------------------------------------------------------
// Actions factories
// -----------------------------------------------------------------------------
