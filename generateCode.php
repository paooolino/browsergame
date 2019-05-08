<?php
$MAIN_NAMESPACE_NAME = "BGame";
$APP_DIRECTORY = "BGame";

$config = parse_ini_file(__DIR__ . '../generateCode_config.ini', true, INI_SCANNER_RAW);

/*
. routes (entry point)
  . each route instantiates a controller
    . each controller has dependencies
    . each controller may call one or more models
      . each model has dependencies
    . each controller may call one or more actions
      . each action has dependencies
  . each route may load a template
    . each template may call one or more widgets
    
*/

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
$code = "<?php\r\n";
foreach ($config as $route_name => $route_config) {
  $rpath = $route_config["path"];
  $rClassName = $MAIN_NAMESPACE_NAME . '\\Controller\\' . ucfirst(strtolower($route_name)) . 'Controller';
  
  $code .= "\$app->get('$rpath', '$rClassName')->setName('$route_name');\r\n";
}
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
foreach ($config as $route_name => $route_config) {
  $filename = ucfirst(strtolower($route_name)) . 'Controller.php';
  $deps_members = '';
  $deps_list = '';
  $deps_assign = '';
  $invoke_content = '';
  
  if (isset($route_config["deps"])) {
    $deps = array_map("trim", explode(",", $route_config["deps"]));
    foreach ($deps as $dep) {
      $deps_members .= "  private \$$dep;\r\n";
      $deps_assign .= "    \$this->$dep = $dep;\r\n";
    }
    $deps_list = implode(", ", $deps);
  }
  if (isset($route_config["method"]) && $route_config["method"] == "post") {
  } else {
    $templatename = $route_config["template"] . '.php';
    $invoke_content .= "    return \$this->view->render(\$response, '$templatename', [\r\n";
    $invoke_content .= "      //\r\n";
    $invoke_content .= "    ]);";
  }
  
  $code = <<<END_OF_CODE
<?php
namespace $MAIN_NAMESPACE_NAME\Controller;

class $filename {
  
$deps_members  
  public function __construct($deps_list) {
$deps_assign  }
  
  public function __invoke(\$request, \$response, \$args) {
$invoke_content
  }
}
END_OF_CODE;
  
  create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src/Controller', $filename, $code);
}

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
foreach ($config as $route_name => $route_config) {
  if (isset($route_config["template"])) {
    $filename = $route_config["template"] . '.php';
    $code = <<<END_OF_CODE
<?php require __DIR__ . '/partials/header.php'; ?>

template: $filename

<?php require __DIR__ . '/partials/footer.php'; ?>
END_OF_CODE;
    create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default', $filename, $code);
  }
}

// ============================================================================
//  partials: header
// ============================================================================
$code = <<<END_OF_CODE
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title><?php echo \$seo_title; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo \$templatePath; ?>/css/style.css">
</head>
<body>
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default/css', 'style.css', $code);

// ============================================================================
//  partials: footer
// ============================================================================
$code = <<<END_OF_CODE
  <script src="<?php echo \$templatePath; ?>/js/script.js"></script>
</body>
</html>
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default/css', 'style.css', $code);

// ============================================================================
//  css
// ============================================================================
$code = <<<END_OF_CODE
* {margin:0;padding:0;}
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default/css', 'style.css', $code);

// ============================================================================
//  js
// ============================================================================
$code = '';
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default/js', 'index.js', $code);