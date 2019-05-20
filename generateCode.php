<?php
require __DIR__ . '/vendor/autoload.php';
use Ifsnop\Mysqldump as IMysqldump;

$APP_DIRECTORY = "UserDemo";
$MAIN_NAMESPACE_NAME = $APP_DIRECTORY;

$config_all = parse_ini_file(__DIR__ . '../' . $APP_DIRECTORY . '.ini', true, INI_SCANNER_RAW);
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
  
  $code = preserve_developer_code($file, $code);
  
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
      $code = <<<END_OF_CODE
<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc [Please add a description here for this sub-template]
 *
 *  @status 0 
 */
/* === DEVELOPER END */
?>
Please edit the template source file in /templates/default/src/partials/' . $subfilename
END_OF_CODE;
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

function preserve_developer_code($file, $code) {
  // se il file non esiste mantengo il codice così com'è
  if (!file_exists($file))
    return $code;
  
  // trovo i pezzi di codice da preservare dal file originale
  $file_content = file_get_contents($file);
  $start = ("\/\* === DEVELOPER BEGIN \*\/");
  $end = ("\/\* === DEVELOPER END \*\/");
  $preserve_matches = [];
  preg_match_all("/$start(.*?)$end/s", $file_content, $matches);
  
  if (count($matches[0]) > 0) {
    // metto dei segnaposto nel nuovo codice
    $code = preg_replace("/$start(.*?)$end/s", "{{DEVELOPER_CODE}}", $code);
    
    // sostituisco i segnaposto con il codice da preservare
    foreach ($matches[0] as $match) {
      $code = replace_first_occurrence("{{DEVELOPER_CODE}}", $match, $code);
    }
  }
  
  return $code;
}

function replace_first_occurrence($search, $replace, $string) {
  $pos = strpos($string, $search);
  if ($pos !== false) {
    $string = substr_replace($string, $replace, $pos, strlen($search));
  }
  return $string;
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
  $deps = [];
  if (isset($service_config["deps"])) {
    $deps = array_map(function($dep) {
      return '$c->' . $dep;
    }, sToArr($service_config["deps"]));
  }
  $deps = implode(", ", $deps);
  
  $otherServices .= <<<END_OF_CODE
\$container['$service'] = function(\$c) {
  return new $MAIN_NAMESPACE_NAME\\$service_name($deps);
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

  // se c'è un template, aggiunge automaticamente la dipendenza dalla view
  // se c'è la view passo anche app, serve per recuperare la templateUrl
  // se non lo è, passo router che serve sicuramente per il redirect
  // passo sempre anche app, può includere funzioni di utilità da usare anche nelle action.
  if (isset($route_config["template"])) {
    $deps[] = '$c->view';
    $deps[] = '$c->app';
  } else {
    $deps[] = '$c->router';
    $deps[] = '$c->app';
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
  $viewmodels_content = '';
  $action_content = '';
  $invoke_content = '';
  $models_vars = '';
  $file_descriptor = '';
  
  $deps = [];
  if (isset($route_config["deps"])) {
    $deps = array_map("trim", explode(",", $route_config["deps"]));
  }
  if (isset($route_config["models"])) {
    // models are dependencies themselves
    $deps = array_merge($deps, array_map(function($model) {
      return ucfirst(trim($model)) . "Model";
    }, explode(",", $route_config["models"])));
  }
  
  // se c'è un template, aggiunge automaticamente la dipendenza dalla view
  // se c'è la view passo anche app, serve per recuperare la templateUrl
  // se non lo è, passo router che serve sicuramente per il redirect
  // passo sempre anche app, può includere funzioni di utilità da usare anche nelle action.
  if (isset($route_config["template"])) {
    $deps[] = "view";
    $deps[] = "app";
  } else {
    $deps[] = "router";
    $deps[] = "app";
  }
  foreach ($deps as $dep) {
    $deps_members .= "  private \$$dep;\r\n";
    $deps_assign .= "    \$this->$dep = \$$dep;\r\n";
  }
  $deps_list = implode(", ", array_map(function($d) { return '$' . $d; }, $deps));
  
  if (isset($route_config["models"])) {
    $models = array_map("trim", explode(",", $route_config["models"]));
    foreach ($models as $model) {
      $modelClassName = ucfirst(strtolower($model)) . 'Model';
      $models_vars .= "      \"$model\" => \$$model,\r\n";
    }
  }
  
  if (!isset($route_config["template"])) {
    $desc = isset($route_config["desc"]) ? $route_config["desc"] : "Please add a [desc] attribute to the $route_name route."; 
    $file_descriptor = <<<END_OF_CODE
/* === DEVELOPER BEGIN */
/**
 *  @desc $desc
 *
 *  @status 0 
 */
/* === DEVELOPER END */
END_OF_CODE;

    // look for actions
    $invoke_content .= '    $action_result = $this->doAction($request, $args);' . "\r\n";
    $invoke_content .= '    $redir = $this->router->pathFor($action_result["route_to"]);' . "\r\n";
    $invoke_content .= '    if (isset($action_result["qs"])) {' . "\r\n";
    $invoke_content .= '      $redir .= "?" . http_build_query($action_result["qs"]);' . "\r\n";
    $invoke_content .= '    }' . "\r\n";
    $invoke_content .= '    return $response->withRedirect($redir);' . "\r\n";
    
    $action_content = <<<END_OF_CODE
  /* === DEVELOPER BEGIN */
  private function doAction(\$request, \$args) {
    // create your action here.
    // it should return a redirect descriptor.
    die("please create the action by editing the /src/Controller/$filename file");
    return [
      "route_to" => "<ROUTE_NAME>",
      "qs" => [
        "<key1>" => "<value1>",
        "..." => "..."
      ]
    ];
  }
  /* === DEVELOPER END */
END_OF_CODE;
    
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
    if (isset($route_config["models"])) {
      $file_descriptor = <<<END_OF_CODE
/* === DEVELOPER BEGIN */
/**
 *  @status 0 
 */
/* === DEVELOPER END */
END_OF_CODE;

      $models = array_map("trim", explode(",", $route_config["models"]));
      foreach ($models as $model) {
        $models_content .= "    \$model = \$this->getdata_${model}Model(\$request, \$args);\r\n";
        $viewmodels_content .= <<<END_OF_CODE
  /* === DEVELOPER BEGIN */
  private function getdata_${model}Model(\$request, \$args) {
    // call the pure model to retrieve data
    //return \$this->${model}Model(); 
  }
  /* === DEVELOPER END */
END_OF_CODE;
      }
    }
    
    $templatename = $route_config["template"] . '.php';
    $invoke_content .= "    return \$this->view->render(\$response, '$templatename', [\r\n";
    $invoke_content .= "      \"templateUrl\" => \$this->app->templateUrl,\r\n";
    $invoke_content .= $models_vars;
    $invoke_content .= "    ]);";
  }
  
  $code = <<<END_OF_CODE
<?php
$file_descriptor
namespace $MAIN_NAMESPACE_NAME\Controller;

class $classname {
$deps_members  
  public function __construct($deps_list) {
$deps_assign  }
  
  public function __invoke(\$request, \$response, \$args) {  
$models_content
$invoke_content
  }
  
${action_content}${viewmodels_content}
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
  
  $desc = isset($model_config["desc"]) ? $model_config["desc"] : "Please add a [desc] attribute to the $model_name model."; 
  $file_descriptor = <<<END_OF_CODE
/* === DEVELOPER BEGIN */
/**
 *  @desc $desc
 *
 *  @status 0 
 */
/* === DEVELOPER END */
END_OF_CODE;
  
  $custom_content = <<<END_OF_CODE
  /* === DEVELOPER BEGIN */
  public function get() {
    // retrieve and return requested data here
  }  
  /* === DEVELOPER END */
END_OF_CODE;

      $code = <<<END_OF_CODE
<?php
$file_descriptor
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
//  App.php
// ============================================================================
$custom_content = <<<END_OF_CODE
  /* === DEVELOPER BEGIN */
  
  // add your public functions here
  
  /* === DEVELOPER END */
END_OF_CODE;

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
  
  public function select(\$query, \$data) {
    \$sth = \$this->_conn->prepare(\$query);
    \$sth->execute(\$data);
    if (!\$sth)
      return [];
    return \$sth->fetchAll(\PDO::FETCH_ASSOC);
  }
  
  public function query(\$query, \$data) {
    \$sth = \$this->_conn->prepare(\$query);
    \$result = \$sth->execute(\$data);
    return \$result;
  } 
}
END_OF_CODE;
create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src', 'DB.php', $code);

// ============================================================================
//  services
// ============================================================================
foreach ($config_services as $service => $service_config) {
  $service_name = ucfirst($service);
  $deps_members = '';
  $deps_list = '';
  $deps_assign = '';
  
  if (isset($service_config["deps"])) {
    $deps = array_map("trim", explode(",", $service_config["deps"]));
    foreach ($deps as $dep) {
      $deps_members .= "  private \$$dep;\r\n";
      $deps_assign .= "    \$this->$dep = \$$dep;\r\n";
    }
    $deps_list = implode(", ", array_map(function($d) { return '$' . $d; }, $deps));
  }
  
  $desc = isset($route_config["desc"]) ? $route_config["desc"] : "Please add a [desc] attribute to the $service service."; 
    
  $custom_content = <<<END_OF_CODE
  /* === DEVELOPER BEGIN */
  
  // add your public functions here
  
  /* === DEVELOPER END */
END_OF_CODE;

  $code = <<<END_OF_CODE
<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc $desc
 *
 *  @status 0 
 */
/* === DEVELOPER END */
namespace $MAIN_NAMESPACE_NAME;

class $service_name {
$deps_members    
  public function __construct($deps_list) {
$deps_assign  }
  
$custom_content
}
END_OF_CODE;
  create_file(__DIR__ . '/' . $APP_DIRECTORY . '/src', $service_name . '.php', $code);
}

// ============================================================================
//  templates
// ============================================================================
foreach ($config as $route_name => $route_config) {
  if (isset($route_config["template"])) {
    $tpl_source_dir = __DIR__ . '/' . $APP_DIRECTORY . '/templates/default/src'; 
    $tpl_dest_dir = __DIR__ . '/' . $APP_DIRECTORY . '/templates/default'; 
    $filename = $route_config["template"] . '.php';
    if (!file_exists($tpl_source_dir . '/' . $filename)) {
      $desc = isset($route_config["desc"]) ? $route_config["desc"] : "Please add a [desc] attribute to the $route_name route."; 
      $code = <<<END_OF_CODE
<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc $desc
 *
 *  @status 0 
 */
/* === DEVELOPER END */
?>
Please edit the template source file in /templates/default/src/' . $filename
END_OF_CODE;
      create_file($tpl_source_dir, $filename, $code);
    }
    compile_template($tpl_source_dir, $tpl_dest_dir, $filename, true);
  }
}

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
//  copy the developer assistant
// ============================================================================
$source = __DIR__ . "/developer_assistant.php";
$dest = __DIR__ . '/' . $APP_DIRECTORY . "/developer_assistant.php";
copy($source, $dest);

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