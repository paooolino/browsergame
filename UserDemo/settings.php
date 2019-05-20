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
        'DBNAME' => 'userdemo',
      ],
    ],
  ];