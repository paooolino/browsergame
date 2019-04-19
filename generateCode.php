<?php

// ============================================================================
//  index.php
// ============================================================================

$code = <<<END_OF_CODE
<?php
  require __DIR__ . '/vendor/autoload.php';

  // Instantiate the Slim App
  \$slim_config = parse_ini_file(__DIR__ . '/config/slim.ini', true, INI_SCANNER_RAW);
  \$app = new Slim\App(\$slim_config);

  // Set up dependencies
  require __DIR__ . '/src/dependencies.php';

  // App middleware
  require __DIR__ . '/src/middleware.php';

  // App routes
  require __DIR__ . '/src/routes.php';

  \$app->run();

  die();

END_OF_CODE;

file_put_contents(__DIR__ . '/index.php', $code);



// ============================================================================
//  routes.php
// ============================================================================

$code = <<<END_OF_CODE
<?php
  \$routes_config = parse_ini_file(__DIR__ . '/../config/routes.ini', true, INI_SCANNER_RAW);
  foreach (\$routes_config as \$section => \$route) {
    \$controllerClass = 'Browsergame\Controller\\\' . (\$route["controllerClass"] ?? str_replace(" " , "", ucwords(str_replace("_", " ", \$section))));
    \$app->get(\$route["path"], \$controllerClass)->setName(\$section);
  }
  
END_OF_CODE;

file_put_contents(__DIR__ . '/src/routes.php', $code);



// ============================================================================
//  
// ============================================================================

file_put_contents(__DIR__ . '/src/dependencies.php', "");
file_put_contents(__DIR__ . '/src/middleware.php', "");
