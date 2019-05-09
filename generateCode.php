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
  return new Slim\Views\PhpRenderer(\$templatePath, [
    "router" => \$c->router
  ]);
};

\$container['app'] = function (\$c) {
  return new $MAIN_NAMESPACE_NAME\App(\$c->settings["templateName"]);
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
$code = <<<END_OF_CODE
<?php
  \$app->add('$MAIN_NAMESPACE_NAME\Middleware\AppInit');
  \$app->add('$MAIN_NAMESPACE_NAME\Middleware\Auth');
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'middleware.php', $code);

// ============================================================================
//  routes.php
// ============================================================================
$code = "<?php\r\n";
foreach ($config as $route_name => $route_config) {
  $rpath = $route_config["path"];
  $rClassName = $MAIN_NAMESPACE_NAME . '\\Controller\\' . ucfirst(strtolower($route_name)) . 'Controller';
  $method = (isset($route_config["method"])) ? $route_config["method"] : "get";
  
  $code .= "\$app->$method('$rpath', '$rClassName')->setName('$route_name');\r\n";
}
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'routes.php', $code);

// ============================================================================
//  settings.php
// ============================================================================
$code = <<<END_OF_CODE
<?php
  return [
    'settings' => [
      // Slim settings
      'displayErrorDetails' => true,
      'addContentLengthHeader' => false,
      'determineRouteBeforeAppMiddleware' => true,

      // App settings
      'templateName' => 'default',

      // Database settings
      'DB' => [
        'HOST' => 'localhost',
        'USER' => 'root',
        'PASS' => '',
        'DBNAME' => '',
      ],
    ],
  ];
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'settings.php', $code);
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'settings.sample', $code);

// ============================================================================
//  controllers
// ============================================================================
foreach ($config as $route_name => $route_config) {
  $classname = ucfirst(strtolower($route_name)) . 'Controller';
  $filename = $classname . '.php';
  $deps_members = '';
  $deps_list = '';
  $deps_assign = '';
  $invoke_content = '';
  
  if (isset($route_config["deps"])) {
    $deps = array_map("trim", explode(",", $route_config["deps"]));
    foreach ($deps as $dep) {
      $deps_members .= "  private \$$dep;\r\n";
      $deps_assign .= "    \$this->$dep = \$$dep;\r\n";
    }
    $deps_list = implode(", ", array_map(function($d) { return '$' . $d; }, $deps));
  }
  if (isset($route_config["method"]) && $route_config["method"] == "post") {
    // look for actions
    if (isset($route_config["actions"])) {
      $actions_arr = array_map("trim", explode(',', $route_config["actions"]));
      foreach ($actions_arr as $action) {
        $invoke_content .= "    // invoking action $action \r\n";
      }      
    }
  } else {
    $templatename = $route_config["template"] . '.php';
    $invoke_content .= "    return \$this->view->render(\$response, '$templatename', [\r\n";
    $invoke_content .= "      \"templateUrl\" => \$this->app->templateUrl\r\n";
    $invoke_content .= "    ]);";
  }
  
  $code = <<<END_OF_CODE
<?php
namespace $MAIN_NAMESPACE_NAME\Controller;

class $classname {
  
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
//  middlewares: AppInit
// ============================================================================
$code = <<<END_OF_CODE
<?php
namespace $MAIN_NAMESPACE_NAME\Middleware;

class AppInit {
  
  private \$app;
  
  public function __construct(\$app) {
    \$this->app = \$app;
  }
  
  public function __invoke(\$request, \$response, \$next) {
    \$this->app->baseUrl = \$request->getUri()->getBaseUrl();
    \$this->app->templateUrl = \$this->app->baseUrl 
      . '/$APP_DIRECTORY'
      . '/templates'
      . '/' . \$this->app->templateName;
      
    return \$next(\$request, \$response);
  }
}
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src/Middleware', 'AppInit.php', $code);

// ============================================================================
//  middlewares: Auth
// ============================================================================
$code = <<<END_OF_CODE
<?php
namespace $MAIN_NAMESPACE_NAME\Middleware;

class Auth {
  public function __invoke(\$request, \$response, \$next) {
    return \$next(\$request, \$response);
  }
}
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src/Middleware', 'Auth.php', $code);

// ============================================================================
//  widgets
// ============================================================================
foreach ($config as $route_name => $route_config) {
  if (isset($route_config["widgets"])) {
    $widgets_arr = array_map("trim", explode(',', $route_config["widgets"]));
    foreach ($widgets_arr as $widget) {
      $code = <<<END_OF_CODE
<!-- $widget -->
<p>Please edit this widget file in '/templates/default/widgets/$widget.php'</p>

END_OF_CODE;
      create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default/widgets', $widget . '.php', $code, false);
    }
  }
}

// ============================================================================
//  actions
// ============================================================================
foreach ($config as $route_name => $route_config) {
  if (isset($route_config["actions"])) {
    $actions_arr = array_map("trim", explode(',', $route_config["actions"]));
    foreach ($actions_arr as $action) {
      $classname = ucfirst(strtolower($action)) . 'Action';
      $filename = $classname . '.php';
      $code = <<<END_OF_CODE
<?php
namespace $MAIN_NAMESPACE_NAME\Action;

class $classname {
  
  public function __construct() {
    //
  }
  
  public function __invoke() {
    //
  }
}
END_OF_CODE;
      create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src/Action', $filename, $code);
    }
  }
}

// ============================================================================
//  App.php
// ============================================================================
$code = <<<END_OF_CODE
<?php
namespace $MAIN_NAMESPACE_NAME;

class App {
  
  public \$baseUrl;
  public \$templateName;
  public \$templateUrl;
  
  public function __construct(\$templateName) {
    \$this->templateName = \$templateName;
  }
  
}
END_OF_CODE;
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
    $widgets = '';
    if (isset($route_config["widgets"])) {
      $widgets_arr = array_map("trim", explode(',', $route_config["widgets"]));
      $widgets = implode("\r\n", array_map(function($item) {
        return '<?php require __DIR__ . \'/widgets/' . $item . '.php\'; ?>';
      }, $widgets_arr));
    }
    $code = <<<END_OF_CODE
<?php require __DIR__ . '/partials/header.php'; ?>

$widgets

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
  <link rel="stylesheet" type="text/css" href="<?php echo \$templateUrl; ?>/css/style.css">
</head>
<body>
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default/partials', 'header.php', $code);

// ============================================================================
//  partials: footer
// ============================================================================
$code = <<<END_OF_CODE
  <script src="<?php echo \$templateUrl; ?>/js/script.js"></script>
</body>
</html>
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default/partials', 'footer.php', $code);

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