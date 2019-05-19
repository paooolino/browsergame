<?php

$container['view'] = function ($c) {
  $templatePath = __DIR__ . '/templates/' . $c->settings["templateName"];
  return new Slim\Views\PhpRenderer($templatePath, [
    "router" => $c->router
  ]);
};

$container['app'] = function ($c) {
  return new BGame2\App($c->settings["templateName"]);
};

$container['db'] = function($c) {
  $db = new BGame2\DB();
  $db->setupMySql(
    $c->settings['DB']['HOST'],
    $c->settings['DB']['USER'],
    $c->settings['DB']['PASS'],
    $c->settings['DB']['DBNAME']
  );
  return $db;
};

$container['admin'] = function($c) {
  return new BGame2\Admin($c->db);
};

// -----------------------------------------------------------------------------
// Middleware factories
// -----------------------------------------------------------------------------
$container['BGame2\Middleware\AppInit'] = function ($c) {
  return new BGame2\Middleware\AppInit($c->app);
};

$container['BGame2\Middleware\Auth'] = function ($c) {
  return new BGame2\Middleware\Auth($c->app);
};
// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------
$container['BGame2\Controller\HomeController'] = function ($c) {
  return new BGame2\Controller\HomeController($c->view, $c->app, $c->LeaguesModel);
};

$container['BGame2\Controller\LeagueController'] = function ($c) {
  return new BGame2\Controller\LeagueController($c->view, $c->app, $c->LeaguesModel, $c->LeagueModel, $c->StandingsModel, $c->FixturesModel);
};

$container['BGame2\Controller\TeamController'] = function ($c) {
  return new BGame2\Controller\TeamController($c->view, $c->app, $c->LeaguesModel, $c->TeamModel);
};

$container['BGame2\Controller\PlayerController'] = function ($c) {
  return new BGame2\Controller\PlayerController($c->view, $c->app, $c->LeaguesModel, $c->PlayerModel);
};

$container['BGame2\Controller\MatchController'] = function ($c) {
  return new BGame2\Controller\MatchController($c->view, $c->app, $c->LeaguesModel, $c->MatchModel);
};

$container['BGame2\Controller\LoginController'] = function ($c) {
  return new BGame2\Controller\LoginController($c->view, $c->app, $c->LeaguesModel);
};

$container['BGame2\Controller\Login_actionController'] = function ($c) {
  return new BGame2\Controller\Login_actionController($c->router, $c->app);
};

$container['BGame2\Controller\RegisterController'] = function ($c) {
  return new BGame2\Controller\RegisterController($c->view, $c->app, $c->LeaguesModel);
};

$container['BGame2\Controller\Register_exController'] = function ($c) {
  return new BGame2\Controller\Register_exController($c->router, $c->app);
};

$container['BGame2\Controller\Register_confirm_exController'] = function ($c) {
  return new BGame2\Controller\Register_confirm_exController($c->router, $c->app);
};

$container['BGame2\Controller\DashboardController'] = function ($c) {
  return new BGame2\Controller\DashboardController($c->view, $c->app);
};

$container['BGame2\Controller\LogoutController'] = function ($c) {
  return new BGame2\Controller\LogoutController();
};

$container['BGame2\Controller\AdminController'] = function ($c) {
  return new BGame2\Controller\AdminController($c->view, $c->app, $c->LeaguesModel, $c->AdminmenuitemsModel);
};

$container['BGame2\Controller\Admin_messageController'] = function ($c) {
  return new BGame2\Controller\Admin_messageController($c->view, $c->app, $c->admin, $c->LeaguesModel, $c->AdminmenuitemsModel);
};

$container['BGame2\Controller\Admin_newseasonController'] = function ($c) {
  return new BGame2\Controller\Admin_newseasonController($c->router, $c->admin);
};

$container['BGame2\Controller\Admin_create_playersController'] = function ($c) {
  return new BGame2\Controller\Admin_create_playersController($c->view, $c->app, $c->admin, $c->LeaguesModel, $c->AdminmenuitemsModel, $c->CountsModel);
};

$container['BGame2\Controller\Admin_create_players_exController'] = function ($c) {
  return new BGame2\Controller\Admin_create_players_exController($c->router, $c->admin);
};

$container['BGame2\Controller\Admin_schedule_matchController'] = function ($c) {
  return new BGame2\Controller\Admin_schedule_matchController($c->router, $c->admin);
};

$container['BGame2\Controller\Admin_tableController'] = function ($c) {
  return new BGame2\Controller\Admin_tableController($c->view, $c->admin, $c->LeaguesModel, $c->TableModel);
};

$container['BGame2\Controller\Admin_recordController'] = function ($c) {
  return new BGame2\Controller\Admin_recordController($c->view, $c->admin, $c->LeaguesModel, $c->TableModel, $c->RecordModel);
};

$container['BGame2\Controller\Admin_record_newController'] = function ($c) {
  return new BGame2\Controller\Admin_record_newController($c->view, $c->admin, $c->LeaguesModel, $c->TableModel);
};

$container['BGame2\Controller\Admin_record_editController'] = function ($c) {
  return new BGame2\Controller\Admin_record_editController($c->view, $c->admin, $c->LeaguesModel, $c->TableModel, $c->RecordModel);
};

$container['BGame2\Controller\Admin_record_deleteController'] = function ($c) {
  return new BGame2\Controller\Admin_record_deleteController($c->view, $c->admin, $c->LeaguesModel, $c->TableModel, $c->RecordModel);
};


// -----------------------------------------------------------------------------
// Model factories
// -----------------------------------------------------------------------------
$container['LeaguesModel'] = function ($c) {
  return new BGame2\Model\LeaguesModel($c->db);
};

$container['LeagueModel'] = function ($c) {
  return new BGame2\Model\LeagueModel($c->db);
};

$container['TeamModel'] = function ($c) {
  return new BGame2\Model\TeamModel($c->db);
};

$container['PlayerModel'] = function ($c) {
  return new BGame2\Model\PlayerModel($c->db);
};

$container['MatchModel'] = function ($c) {
  return new BGame2\Model\MatchModel($c->db);
};

$container['AdminmenuitemsModel'] = function ($c) {
  return new BGame2\Model\AdminmenuitemsModel($c->router);
};

$container['CountsModel'] = function ($c) {
  return new BGame2\Model\CountsModel($c->db);
};


// -----------------------------------------------------------------------------
// Actions factories
// -----------------------------------------------------------------------------
