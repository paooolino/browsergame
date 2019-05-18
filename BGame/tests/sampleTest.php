<?php
use PHPUnit\Framework\TestCase;

final class Login_exControllerTest extends TestCase {
    
  public function testCanBeUsedAsString(): void {
    /*
    $action = new \BGame\Controller\Login_exController($router, $app);
    
    $environment = \Slim\Http\Environment::mock([
      'REQUEST_METHOD' => 'GET',
      'REQUEST_URI' => '/echo',
      'QUERY_STRING'=>'foo=bar']
    );
    
    $request = \Slim\Http\Request::createFromEnvironment($environment);
    $response = new \Slim\Http\Response();
    
    // run the controller action and test it
    $response = $action($request, $response, []);
    
    $this->assertSame((string)$response->getBody(), '{"foo":"bar"}');
    */
  }
  
}
