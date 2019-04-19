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

$routes_code = '';
$routes_config = parse_ini_file(__DIR__ . '/config/routes.ini', true, INI_SCANNER_RAW);
foreach ($routes_config as $section => $route) {
  $controllerClass = $route["controllerClass"] ?? MAIN_NAMESPACE_NAME . '\Controller\\' . str_replace(" " , "", ucwords(str_replace("_", " ", strtolower($section))));
  makeClass($controllerClass);
  $routes_code .= "  \$app->get('" . $route["path"] . "', '" . $controllerClass . "')->setName('" . $section . "');\r\n";
}

$code = <<<END_OF_CODE
<?php
$routes_code
  
END_OF_CODE;

file_put_contents(__DIR__ . '/src/routes.php', $code);



// ============================================================================
//  dependencies
// ============================================================================

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
END_OF_CODE;

file_put_contents(__DIR__ . '/src/dependencies.php', $code);



// ============================================================================
//  generator utility functions
// ============================================================================

function makeClass($controllerClass) {
  // get the class file complete pathname
  $classFile = __DIR__ . '\\' . str_replace(MAIN_NAMESPACE_NAME . '\\', 'src\\', $controllerClass) . '.php';
  
  // create directory for class file, if not exists
  $classFile_arr = explode("\\", $classFile);
  array_pop($classFile_arr);
  $classFile_dir = implode("\\", $classFile_arr);
  if (!is_dir($classFile_dir)) {
    mkdir($classFile_dir, 0777, true);
  }
  
  // get the namespace name
  $namespace_arr = explode("\\", $controllerClass);
  $className = array_pop($namespace_arr);
  $namespace = implode("\\", $namespace_arr);
  
  // get the code
$code = <<<END_OF_CODE
<?php
namespace $namespace;   
  
class $className {
  private \$view;
  
  public function __construct(\$view) {
    \$this->view = \$view;
  }
  
  public function __invoke(\$request, \$response, \$args) {
    return \$this->view->render(\$response, 'template.php', [
    ]);
  }
}

END_OF_CODE;

  file_put_contents($classFile, $code);
}
