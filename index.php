<?php
  require __DIR__ . '/vendor/autoload.php';

  // Instantiate the Slim App
  $slim_config = parse_ini_file(__DIR__ . '/config/slim.ini', true, INI_SCANNER_RAW);
  $app = new Slim\App($slim_config);

  // Set up dependencies
  require __DIR__ . '/src/dependencies.php';

  // App middleware
  require __DIR__ . '/src/middleware.php';

  // App routes
  require __DIR__ . '/src/routes.php';

  $app->run();

  die();
