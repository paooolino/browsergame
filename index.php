<?php
  require __DIR__ . '/vendor/autoload.php';

  // Instantiate the Slim App
  $slim_settings = require __DIR__ . '/config/slim.php';
  $app = new Slim\App($slim_settings);

  // Set up dependencies
  require __DIR__ . '/src/dependencies.php';

  // App middleware
  require __DIR__ . '/src/middleware.php';

  // App routes
  require __DIR__ . '/src/routes.php';

  $app->run();

  die();
