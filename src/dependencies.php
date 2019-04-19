<?php
// DIC configuration

$container = $app->getContainer();

$container['view'] = function ($c) {
  $templatePath = __DIR__ . '/../templates/'
    . $c->settings['templateName'];
  return new Slim\Views\PhpRenderer($templatePath, [
    "router" => $c->router
  ]);
};