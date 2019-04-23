<?php
define("MAIN_NAMESPACE_NAME", "BGame");

// ============================================================================
//  index.php
// ============================================================================

$code = <<<END_OF_CODE
<?php
  require __DIR__ . '/vendor/autoload.php';

  // Instantiate the Slim App
  \$slim_settings = parse_ini_file(__DIR__ . '/config/slim.ini', true, INI_SCANNER_RAW);
  \$app = new Slim\App([
    "settings" => \$slim_settings
  ]);

  // Set up dependencies
  require __DIR__ . '/src/dependencies.php';

  // App routes
  require __DIR__ . '/src/routes.php';

  \$app->run();

  die();

END_OF_CODE;

file_put_contents(__DIR__ . '/index.php', $code);



// ============================================================================
//  routes and controllers
// ============================================================================

makebaseControllerClass();

$routes_code = '';
$controller_factories_code = '';
$namespace = MAIN_NAMESPACE_NAME;
$routes_config = parse_ini_file(__DIR__ . '/config/routes.ini', true, INI_SCANNER_RAW);
foreach ($routes_config as $route_name => $route_config) {
  $controllerClass = str_replace(":", "_", $route_config["controllerClass"] ?? MAIN_NAMESPACE_NAME . '\Controller\\' . str_replace(" " , "", ucwords(str_replace("_", " ", strtolower($route_name)))));
  $models = my_explode($route_config["models"] ?? "");
  $actions = my_explode($route_config["actions"] ?? "");
  $widgets = my_explode($route_config["widgets"] ?? "");

  $template = $route_config["template"] ?? "";
  
  makeClass($controllerClass, $template, $models, $actions);
  
  if ($template != "")
    makeTemplate($template, $widgets);
  
  $method = "get";
  if (strpos($route_name, ":") !== false) 
    $method = strtolower(explode(":", $route_name)[1]);
  $routes_code .= "  \$app->$method('" . $route_config["path"] . "', '" . $controllerClass . "')->setName('" . $route_name . "');\r\n";

  $controller_factories_code .= "\$container['$controllerClass'] = function (\$c) {\r\n";
  $controller_factories_code .= "  return new $controllerClass(\$c->view);\r\n";
  $controller_factories_code .= "};\r\n";
  $controller_factories_code .= "\r\n";
}

$code = <<<END_OF_CODE
<?php
$routes_code
  
END_OF_CODE;

mkdir_ifnotexists(__DIR__ . '/src');
file_put_contents(__DIR__ . '/src/routes.php', $code);



// ============================================================================
//  dependencies
// ============================================================================

$namespace = MAIN_NAMESPACE_NAME;

$code = <<<END_OF_CODE
<?php
// DIC configuration

\$container = \$app->getContainer();

\$container['view'] = function (\$c) {
  \$templatePath = __DIR__ . '/../templates/'
    . \$c->settings['templateName'];
  return new Slim\Views\PhpRenderer(\$templatePath, [
    "router" => \$c->router
  ]);
};

\$container['app'] = function (\$c) {
  return new $namespace\App();
};

END_OF_CODE;

$code .= "\r\n" . $controller_factories_code;

mkdir_ifnotexists(__DIR__ . '/src');
file_put_contents(__DIR__ . '/src/dependencies.php', $code);



// ============================================================================
//  App
// ============================================================================

$namespace = MAIN_NAMESPACE_NAME;

$code = <<<END_OF_CODE
<?php
namespace $namespace;

class App {
  public \$appVersion = '0.0.1dev';
  public \$templatePath;
  
  public function __construct() {
  }
}

END_OF_CODE;

mkdir_ifnotexists(__DIR__ . '/src');
file_put_contents(__DIR__ . '/src/App.php', $code);


// ============================================================================
//  templates
// ============================================================================

$code = <<<END_OF_CODE
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="<?php echo \$templatePath; ?>css/style.css?v=<?php echo \$appVersion; ?>">
</head>
<body>
  <header>
  </header>
END_OF_CODE;

mkdir_ifnotexists(__DIR__ . '/templates/default/partials');
file_put_contents(__DIR__ . '/templates/default/partials/header.php', $code);



$code = <<<END_OF_CODE
  <footer>
  </footer>
  <script src="<?php echo \$templatePath; ?>js/script.js?v=<?php echo \$appVersion; ?>"></script>
</body>
</html>
END_OF_CODE;

mkdir_ifnotexists(__DIR__ . '/templates/default/partials');
file_put_contents(__DIR__ . '/templates/default/partials/footer.php', $code);



// ============================================================================
//  generator utility functions
// ============================================================================

function makebaseControllerClass() {
  // get the class file complete pathname
  $classFile = __DIR__ . '\\src\\Controller\\BaseController.php';
  $namespace = MAIN_NAMESPACE_NAME . '\\Controller';
  
  // get the code
$code = <<<END_OF_CODE
<?php
namespace $namespace;   
  
class BaseController {
  protected \$view;
  protected \$templatePath;
  
  public function __construct(\$view) {
    \$this->view = \$view;
    \$this->templatePath = "";
  }
}

END_OF_CODE;

  file_put_contents($classFile, $code);  
}

function makeClass($controllerClass, $templateName) {
  // get the class file complete pathname
  $classFile = __DIR__ . '\\' . str_replace(MAIN_NAMESPACE_NAME . '\\', 'src\\', $controllerClass) . '.php';
  
  // create directory for class file, if not exists
  $classFile_arr = explode("\\", $classFile);
  array_pop($classFile_arr);
  $classFile_dir = implode("\\", $classFile_arr);
  mkdir_ifnotexists($classFile_dir);
  
  // get the namespace name
  $namespace_arr = explode("\\", $controllerClass);
  $className = array_pop($namespace_arr);
  $namespace = implode("\\", $namespace_arr);
  
  // get the code
$code = <<<END_OF_CODE
<?php
namespace $namespace;   
  
final class $className extends BaseController { 
  public function __invoke(\$request, \$response, \$args) {
    return \$this->view->render(\$response, '$templateName.php', [
      "templatePath" => \$this->templatePath,
      "appVersion" => ""
    ]);
  }
}

END_OF_CODE;

  file_put_contents($classFile, $code);
}

function makeTemplate($templatename, $widgets) {
  // get the class file complete pathname
  $templateFile = __DIR__ . '/templates/default/' . $templatename . '.php'; 
  
  // get the widgets code
  $widgets_code = '';
  foreach ($widgets as $widget) {
    $widgetPath = __DIR__ . "/templates/default/widgets";
    mkdir_ifnotexists($widgetPath);
    
    $widgetUrl = $widgetPath . "/$widget.php";
    if (!file_exists($widgetUrl))
      file_put_contents($widgetUrl, "");  
    
    $widgets_code .= "<?php require __DIR__ . '/widgets/$widget.php'; ?>\r\n";
  }
  
  // get the code
$code = <<<END_OF_CODE
<?php require __DIR__ . '/partials/header.php'; ?>

$widgets_code

<?php require __DIR__ . '/partials/footer.php';


END_OF_CODE;

  file_put_contents($templateFile, $code);  
}

function mkdir_ifnotexists($path) {
  if (!is_dir($path))
    mkdir($path, 0777, true);
}

function my_explode($s) {
  if ($s == "")
    return [];
  return array_map("trim", explode(",", $s));
}
