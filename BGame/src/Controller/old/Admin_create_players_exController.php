<?php
namespace BGame\Controller;

class Admin_create_players_exController {
  private $router;
  private $admin;
  
  public function __construct($router, $admin) {
    $this->router = $router;
    $this->admin = $admin;
  }
  
  public function __invoke($request, $response, $args) {  

    $action = $this->doAction($request, $response, $args);

    if ($action["status"] == "failure") {
      return $response->withRedirect($this->router->pathFor("ADMIN_MESSAGE"));
    }
    if ($action["status"] == "success") {
      return $response->withRedirect($this->router->pathFor("ADMIN_MESSAGE"));
    }

  }
  
  /* === DO NOT REMOVE THIS COMMENT */
  private function doAction($request, $response, $args) {
    $n = $request->getParsedBody()['n'];
    
    // create your action here.
    $countries = ["it"];
    $roles = ["D", "M", "A"];
    $dir = __DIR__ . '/../../data/names';

    for ($i = 0; $i < $n; $i++) {
      $country = $countries[array_rand($countries)];

      $names = file($dir . "/" . $country . '-names.txt');
      $surnames = file($dir . "/" . $country . '-surnames.txt');
      
      $name = $names[array_rand($names)];
      $surname = $surnames[array_rand($surnames)];
      $age = rand(16,42);
      
      $is_goalkeeper = rand(1,11) == 5;
      $role = $is_goalkeeper ? "P" : $roles[array_rand($roles)];
      
      $ability = rand(0,80);
      $is_champion = rand(1,100) == 50;
      if ($is_champion) {
        $ability += rand(0,20);
      }
      $form = rand(0,100);
      
      $result = $this->admin->createPlayer([
        "name" => $name,
        "surname" => $surname,
        "age" => $age,
        "role" => $role,
        "ability" => $ability,
        "form" => $form
      ]);

      if (!$result) {
        return [
          "status" => "failure"
        ];
      }
    }

    return [
      "status" => "success"
    ];
  }
  /* === DO NOT REMOVE THIS COMMENT */
}