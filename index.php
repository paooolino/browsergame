<?php
  require __DIR__ . '/vendor/autoload.php';

  // Instantiate the Slim App
  $slim_settings = parse_ini_file(__DIR__ . '/config/slim.ini', true, INI_SCANNER_RAW);
  $app = new Slim\App([
    "settings" => $slim_settings
  ]);

  // Set up dependencies
  require __DIR__ . '/src/dependencies.php';

  // App routes
  require __DIR__ . '/src/routes.php';

  $app->run();

  die();
