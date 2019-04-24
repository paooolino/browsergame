<?php
$MAIN_NAMESPACE_NAME = "BGame";
$APP_DIRECTORY = "BGame";

$config = parse_ini_file(__DIR__ . '../generateCode_config.ini', true, INI_SCANNER_RAW);

// ============================================================================
//  functions
// ============================================================================

function create_file($dir, $filename, $code, $force=true) {
  if (!is_dir($dir))
    mkdir($dir, 0777, true);  
  
  $file = $dir . '/' . $filename;
  if ($force || !file_exists($file))
    file_put_contents($file, $code);
}

function longComment($s) {
  $longrow = '// -----------------------------------------------------------------------------';
  return "\r\n$longrow\r\n// $s\r\n$longrow\r\n";
}

function sToArr($s) {
  return array_map('trim', explode(', ', $s));
}

// ============================================================================
//  bootstrap.php
// ============================================================================
$code = <<<END_OF_CODE
<?php
require __DIR__ . '/../vendor/autoload.php';

// Instantiate the Slim App
\$settings = require __DIR__ . '/settings.php';
\$app = new Slim\App(\$settings);

// get the DIC container
\$container = \$app->getContainer();

// Set up dependencies
require __DIR__ . '/dependencies.php';

// App middleware
require __DIR__ . '/middleware.php';

// App routes
require __DIR__ . '/routes.php';

\$app->run();
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'bootstrap.php', $code);

// ============================================================================
//  dependencies.php
// ============================================================================
$services_code = <<<END_OF_CODE
<?php

\$container['view'] = function (\$c) {
  \$templatePath = __DIR__ . '/templates/' . \$c->settings["templateName"];
  return new Slim\Views\PhpRenderer(\$templatePath);
};

\$container['app'] = function (\$c) {
  return new $MAIN_NAMESPACE_NAME\App();
};

\$container['db'] = function(\$c) {
  \$db = new $MAIN_NAMESPACE_NAME\DB();
  \$db->setupMySql(
    \$c->settings['DB']['HOST'],
    \$c->settings['DB']['USER'],
    \$c->settings['DB']['PASS'],
    \$c->settings['DB']['DBNAME']
  );
  return \$db;
};
END_OF_CODE;

$middleware_factories = longComment("Middleware factories");
$middleware_factories .= <<<END_OF_CODE
\$container['$MAIN_NAMESPACE_NAME\Middleware\AppInit'] = function (\$c) {
  return new $MAIN_NAMESPACE_NAME\Middleware\AppInit(\$c->app);
};

\$container['$MAIN_NAMESPACE_NAME\Middleware\Auth'] = function (\$c) {
  return new $MAIN_NAMESPACE_NAME\Middleware\Auth();
};
END_OF_CODE;

$controller_factories = longComment("Controller factories");
foreach ($config as $route_name => $route_config) {
  $controllerName = ucfirst(strtolower($route_name)) . 'Controller';
  $deps = '';
  if (isset($route_config["deps"])) {
    $deps = implode(', ', array_map(function($dep) {
      return '$c->' . $dep;
    }, sToArr($route_config["deps"])));
  }
    $controller_factories .= <<<END_OF_CODE
\$container['$MAIN_NAMESPACE_NAME\Controller\\$controllerName'] = function (\$c) {
  return new $MAIN_NAMESPACE_NAME\Controller\\$controllerName($deps);
};


END_OF_CODE;
}

$model_factories = longComment("Model factories");

$actions_factories = longComment("Actions factories");

$code = $services_code 
  . $middleware_factories 
  . $controller_factories
  . $model_factories
  . $actions_factories;
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'dependencies.php', $code);

// ============================================================================
//  middleware.php
// ============================================================================
$code = '';
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'middleware.php', $code);

// ============================================================================
//  routes.php
// ============================================================================
$code = '';
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'routes.php', $code);

// ============================================================================
//  settings.php
// ============================================================================
$code = '';
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'settings.php', $code);
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'settings.sample', $code);

// ============================================================================
//  controllers
// ============================================================================

// ============================================================================
//  middlewares
// ============================================================================

// ============================================================================
//  widgets
// ============================================================================

// ============================================================================
//  actions
// ============================================================================

// ============================================================================
//  App.php
// ============================================================================
$code = '';
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src', 'App.php', $code);

// ============================================================================
//  DB.php
// ============================================================================
$code = '';
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src', 'DB.php', $code);

// ============================================================================
//  templates
// ============================================================================

// ============================================================================
//  partials: header
// ============================================================================

// ============================================================================
//  partials: footer
// ============================================================================

// ============================================================================
//  css
// ============================================================================

// ============================================================================
//  js
// ============================================================================
