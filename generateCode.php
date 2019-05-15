<?php
require __DIR__ . '/vendor/autoload.php';
use Ifsnop\Mysqldump as IMysqldump;

$MAIN_NAMESPACE_NAME = "BGame";
$APP_DIRECTORY = "BGame";

$config_all = parse_ini_file(__DIR__ . '../generateCode_config.ini', true, INI_SCANNER_RAW);
$models_pos = array_search('::MODELS::', array_keys($config_all));
$services_pos = array_search('::SERVICES::', array_keys($config_all));
// configurazione controllers
$config = array_slice($config_all, 0, $models_pos);
// configurazione models
$config_models = array_slice($config_all, $models_pos+1, ($services_pos - $models_pos) - 1);
// configurazione services
$config_services = array_slice($config_all, $services_pos + 1);

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

function compile_template($src, $dest, $filename, $mainTemplate=false) {
  //echo "*** $filename";
  global $APP_DIRECTORY;

  $tpl = file_get_contents($src . '/' . $filename);
  
  $tags = [];
  preg_match_all("/{{(.*?)}}/", $tpl, $tags);
  for ($i = 0; $i < count($tags[0]); $i++) {
    $tagname = $tags[1][$i];
    
    $tpl_source_dir = __DIR__ . '/' . $APP_DIRECTORY . '/templates/default/src/partials'; 
    $tpl_dest_dir = __DIR__ . '/' . $APP_DIRECTORY . '/templates/default/partials'; 
    $subfilename = $tagname . '.php';
    if (!file_exists($tpl_source_dir . '/' . $subfilename)) {
      $code = 'Please edit the template source file in /templates/default/src/partials/' . $subfilename;
      create_file($tpl_source_dir, $subfilename, $code);
    }
    compile_template($tpl_source_dir, $tpl_dest_dir, $subfilename);
    $tagcode = $mainTemplate 
      ? "<?php require __DIR__ . '/partials/' . '$subfilename'; ?>"
      : "<?php require __DIR__ . '/' . '$subfilename'; ?>";
    $tpl = str_replace("{{".$tagname."}}", $tagcode, $tpl);
    //echo $tpl;
  }
  //echo "****";
  //echo $tpl;
  //echo "*** $filename";
  create_file($dest, $filename, $tpl);
}

function custom_content($file, $default_custom_content) {
  $custom_content = '';
  if (file_exists($file)) {
    $yetcode = file_get_contents($file);
    $matches = [];
    preg_match("/\/\* === DO NOT REMOVE THIS COMMENT \*\/(.*?)\/* === DO NOT REMOVE THIS COMMENT \*\//s", $yetcode, $matches);
    if (count($matches) > 0) {
      $custom_content = "  " . $matches[0];
    }
  }
  if ($custom_content == "") { 
    $custom_content = $default_custom_content;
  }
  return $custom_content;
}

function move_in_old($dir, $files) {
  if (!is_dir($dir . '/old'))
    mkdir($dir . '/old', 0777, true);    
  foreach ($files as $f) {
    rename($dir . '/' . $f, $dir . '/old/' . $f);
  }
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
$otherServices = '';
foreach ($config_services as $service => $service_config) {
  $service_name = ucfirst($service);
  $otherServices .= <<<END_OF_CODE
\$container['$service'] = function(\$c) {
  return new $MAIN_NAMESPACE_NAME\\$service_name();
};

END_OF_CODE;
}

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

$otherServices
END_OF_CODE;

$middleware_factories = longComment("Middleware factories");
$middleware_factories .= <<<END_OF_CODE
\$container['$MAIN_NAMESPACE_NAME\Middleware\AppInit'] = function (\$c) {
  return new $MAIN_NAMESPACE_NAME\Middleware\AppInit(\$c->app);
};

\$container['$MAIN_NAMESPACE_NAME\Middleware\Auth'] = function (\$c) {
  return new $MAIN_NAMESPACE_NAME\Middleware\Auth(\$c->app);
};
END_OF_CODE;

$controller_factories = longComment("Controller factories");
foreach ($config as $route_name => $route_config) {
  $controllerName = ucfirst(strtolower($route_name)) . 'Controller';
  $deps = [];
  if (isset($route_config["deps"])) {
    $deps = array_map(function($dep) {
      return '$c->' . $dep;
    }, sToArr($route_config["deps"]));
  }
  
  if (isset($route_config["models"])) {
    // models are dependencies themselves
    $deps = array_merge($deps, array_map(function($model) {
      return '$c->' . ucfirst(trim($model)) . "Model";
    }, explode(",", $route_config["models"])));
  }

  $deps = implode(", ", $deps);
  
    $controller_factories .= <<<END_OF_CODE
\$container['$MAIN_NAMESPACE_NAME\Controller\\$controllerName'] = function (\$c) {
  return new $MAIN_NAMESPACE_NAME\Controller\\$controllerName($deps);
};


END_OF_CODE;
}

$model_factories = longComment("Model factories");

foreach ($config_models as $model_name => $model_config) {
  $modelName = ucfirst(strtolower($model_name)) . 'Model';
  $deps = '';
  if (isset($model_config["deps"])) {
    $deps = implode(', ', array_map(function($dep) {
      return '$c->' . $dep;
    }, sToArr($model_config["deps"])));
  }
  $model_factories .= <<<END_OF_CODE
\$container['$modelName'] = function (\$c) {
  return new $MAIN_NAMESPACE_NAME\Model\\$modelName($deps);
};


END_OF_CODE;
}


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
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'settings.php', $code, false);
create_file(__DIR__ . '/' . $APP_DIRECTORY, 'settings.sample', $code);

// ============================================================================
//  controllers
// ============================================================================
$existents = [];
if (is_dir(__DIR__ . '/' . $APP_DIRECTORY . '/src/Controller')) {
  $existents = scandir(__DIR__ . '/' . $APP_DIRECTORY . '/src/Controller');
  $existents = array_filter($existents, function($item) { return !($item == "." || $item == ".." || $item == 'old' || strpos($item, '/') !== false); });
}
$controllers = [];
foreach ($config as $route_name => $route_config) {
  $classname = ucfirst(strtolower($route_name)) . 'Controller';
  $filename = $classname . '.php';
  $deps_members = '';
  $deps_list = '';
  //$deps_list_topass = '';
  $deps_assign = '';
  $models_content = '';
  $action_content = '';
  $invoke_content = '';
  $models_vars = '';
  
  if (isset($route_config["deps"])) {
    $deps = array_map("trim", explode(",", $route_config["deps"]));
    if (isset($route_config["models"])) {
      // models are dependencies themselves
      $deps = array_merge($deps, array_map(function($model) {
        return ucfirst(trim($model)) . "Model";
      }, explode(",", $route_config["models"])));
    }
    foreach ($deps as $dep) {
      $deps_members .= "  private \$$dep;\r\n";
      $deps_assign .= "    \$this->$dep = \$$dep;\r\n";
    }
    $deps_list = implode(", ", array_map(function($d) { return '$' . $d; }, $deps));
    //$deps_list_topass = implode(", ", array_map(function($d) { return '$this->' . $d; }, $deps));
  }
  
  if (isset($route_config["models"])) {
    $models = array_map("trim", explode(",", $route_config["models"]));
    foreach ($models as $model) {
      $modelClassName = ucfirst(strtolower($model)) . 'Model';
      $models_content .= "    \$$model = \$this->$modelClassName" . "->get(\$args);\r\n\r\n";
      $models_vars .= "      \"$model\" => \$$model,\r\n";
    }
  }
  
  if (isset($route_config["method"]) && $route_config["method"] == "post") {
    // look for actions
    $invoke_content .= '    $action = $this->doAction();' . "\r\n\r\n";
    
    $action_content = custom_content(
      __DIR__ . '/' . $APP_DIRECTORY . '/src/Controller/' . $filename,
      <<<END_OF_CODE
  /* === DO NOT REMOVE THIS COMMENT */
  private function doAction() {
    // create your action here.
    die("please create the action by editing the /src/Controller/$filename file");
    return [
      "status" => "success"
    ];
  }
  /* === DO NOT REMOVE THIS COMMENT */
END_OF_CODE
    );
    
    if (isset($route_config["failure"])) {
      $invoke_content .= '    if ($action["status"] == "failure") {' . "\r\n"; 
      $invoke_content .= '      return $response->withRedirect($this->router->pathFor("' . $route_config["failure"] . '"));' . "\r\n"; 
      $invoke_content .= '    }' . "\r\n"; 
    }
    if (isset($route_config["success"])) {
      $invoke_content .= '    if ($action["status"] == "success") {' . "\r\n"; 
      $invoke_content .= '      return $response->withRedirect($this->router->pathFor("' . $route_config["success"] . '"));' . "\r\n"; 
      $invoke_content .= '    }' . "\r\n"; 
    }
  } else {
    $templatename = $route_config["template"] . '.php';
    $invoke_content .= "    return \$this->view->render(\$response, '$templatename', [\r\n";
    $invoke_content .= "      \"templateUrl\" => \$this->app->templateUrl,\r\n";
    $invoke_content .= $models_vars;
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
$models_content
$invoke_content
  }
  
$action_content
}
END_OF_CODE;
  
  create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src/Controller', $filename, $code);
  $controllers[] = $filename;
}
move_in_old(__DIR__ . '/' . $APP_DIRECTORY . '/src/Controller', array_diff($existents, $controllers));

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
  
  private \$app;
  
  public function __construct(\$app) {
    \$this->app = \$app;
  }
  
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
//  models
// ============================================================================
$existents = [];
if (is_dir(__DIR__ . '/' . $APP_DIRECTORY . '/src/Model')) {
  $existents = scandir(__DIR__ . '/' . $APP_DIRECTORY . '/src/Model');
  $existents = array_filter($existents, function($item) { return !($item == "." || $item == ".." || $item == 'old' || strpos($item, '/') !== false); });
}
$models = [];
foreach ($config_models as $model_name => $model_config) {
  $classname = ucfirst(strtolower($model_name)) . 'Model';
  $filename = $classname . '.php';
  $deps_members = '';
  $deps_list = '';
  $deps_assign = '';
  
  if (isset($model_config["deps"])) {
    $deps = array_map("trim", explode(",", $model_config["deps"]));
    foreach ($deps as $dep) {
      $deps_members .= "  private \$$dep;\r\n";
      $deps_assign .= "    \$this->$dep = \$$dep;\r\n";
    }
    $deps_list = implode(", ", array_map(function($d) { return '$' . $d; }, $deps));
  }
  
  $custom_content = custom_content(
    __DIR__ . '/' . $APP_DIRECTORY . '/src/Model/' . $filename,
    <<<END_OF_CODE
  /* === DO NOT REMOVE THIS COMMENT */
  public function get(\$args) {
    // retrieve and return requested data here
  }  
  /* === DO NOT REMOVE THIS COMMENT */
END_OF_CODE
      );

      $code = <<<END_OF_CODE
<?php
namespace $MAIN_NAMESPACE_NAME\Model;

class $classname {
$deps_members    
  
  public function __construct($deps_list) {
$deps_assign  }
  
$custom_content
}
END_OF_CODE;
  create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src/Model', $filename, $code);
  $models[] = $filename;
}
move_in_old(__DIR__ . '/' . $APP_DIRECTORY . '/src/Model', array_diff($existents, $models));

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
$custom_content = custom_content(
  __DIR__ . '/' . $APP_DIRECTORY . '/src/App.php',
  <<<END_OF_CODE
  /* === DO NOT REMOVE THIS COMMENT */
  
  // add your public functions here
  
  /* === DO NOT REMOVE THIS COMMENT */
END_OF_CODE
);

$code = <<<END_OF_CODE
<?php
namespace $MAIN_NAMESPACE_NAME;

class App {
  
  public \$templateName;
  public \$templateUrl; /* will be initiated by AppInit middleware */
  public \$baseUrl;     /* will be initiated by AppInit middleware */
  
  public function __construct(\$templateName) {
    \$this->templateName = \$templateName;
  }
  
$custom_content
}
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src', 'App.php', $code);

// ============================================================================
//  DB.php
// ============================================================================
$code = <<<END_OF_CODE
<?php
namespace $MAIN_NAMESPACE_NAME;

class DB {
  
  private \$conn;
  
  public function __construct() {
    //
  }
  
  public function setupMysql(\$host, \$user, \$pass, \$dbname) {
    try {
      \$this->_conn = new \PDO(
        'mysql:host=' . \$host . ';dbname=' . \$dbname, 
        \$user, 
        \$pass,
        array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
      );
      return \$this->_conn;
    } catch (\PDOException \$e) {
      die("db connection error");
    }
  }
  
  public function query(\$query, \$data) {
    \$sth = \$this->_conn->prepare(\$query);
    \$sth->execute(\$data);
    return \$sth->fetchAll(\PDO::FETCH_ASSOC);
  }
}
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src', 'DB.php', $code);

// ============================================================================
//  services
// ============================================================================
foreach ($config_services as $service => $service_config) {
  $service_name = ucfirst($service);
  
  $custom_content = custom_content(
    __DIR__ . '/' . $APP_DIRECTORY . '/src/' . $service_name . '.php',
    <<<END_OF_CODE
  /* === DO NOT REMOVE THIS COMMENT */
  
  // add your public functions here
  
  /* === DO NOT REMOVE THIS COMMENT */
END_OF_CODE
  );

  $code = <<<END_OF_CODE
<?php
namespace $MAIN_NAMESPACE_NAME;

class $service_name {
  
  public function __construct() {

  }
  
$custom_content
}
END_OF_CODE;
  create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src', $service_name . '.php', $code);
}

// ============================================================================
//  templates
// ============================================================================
/*
// THIS IS THE OLD SOLUTION
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
*/
foreach ($config as $route_name => $route_config) {
  if (isset($route_config["template"])) {
    $tpl_source_dir = __DIR__ . '/' . $APP_DIRECTORY . '/templates/default/src'; 
    $tpl_dest_dir = __DIR__ . '/' . $APP_DIRECTORY . '/templates/default'; 
    $filename = $route_config["template"] . '.php';
    if (!file_exists($tpl_source_dir . '/' . $filename)) {
      $code = 'Please edit the template source file in /templates/default/src/' . $filename;
      create_file($tpl_source_dir, $filename, $code);
    }
    compile_template($tpl_source_dir, $tpl_dest_dir, $filename, true);
  }
}

// ============================================================================
//  partials: header
// ============================================================================
/*
// THIS IS THE OLD SOLUTION
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
*/

// ============================================================================
//  partials: footer
// ============================================================================
/*
// THIS IS THE OLD SOLUTION
$code = <<<END_OF_CODE
  <script src="<?php echo \$templateUrl; ?>/js/script.js"></script>
</body>
</html>
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default/partials', 'footer.php', $code);
*/

// ============================================================================
//  css
// ============================================================================
$code = <<<END_OF_CODE
* {margin:0;padding:0;}
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default/css', 'style.css', $code, false);

// ============================================================================
//  js
// ============================================================================
$code = '';
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/templates/default/js', 'index.js', $code);

// ============================================================================
//  database dump
// ============================================================================

try {
  $opts = require __DIR__ . '/' . $APP_DIRECTORY . '/settings.php';
  if (isset($opts['settings']['DB'])) {
    $dump_settings = [
      'add-drop-table' => true,
    ];
    $dump = new IMysqldump\Mysqldump('mysql:host=' . $opts['settings']['DB']['HOST'] . ';dbname=' . $opts['settings']['DB']['DBNAME'], 
      $opts['settings']['DB']['USER'], 
      $opts['settings']['DB']['PASS'],
      $dump_settings);
    $dump->start(__DIR__ . '/' . $APP_DIRECTORY . '/dump.sql');
  }
} catch (\Exception $e) {
    echo 'mysqldump-php error: ' . $e->getMessage();
}