<?php
  $routes_config = parse_ini_file(__DIR__ . '/../config/routes.ini', true, INI_SCANNER_RAW);
  foreach ($routes_config as $section => $route) {
    $controllerClass = 'Browsergame\Controller\\' . ($route["controllerClass"] ?? str_replace(" " , "", ucwords(str_replace("_", " ", $section))));
    $app->get($route["path"], $controllerClass)->setName($section);
  }
  