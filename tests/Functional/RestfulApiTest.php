<?php

use Slim\Http\Environment;
use Slim\Http\Request;
use org\bovigo\vfs\vfsStream;
use Marcosricardoss\Restful\App;
use Marcosricardoss\Restful\User;

require_once 'TestDatabasePopulator.php';
require_once 'env.php';

class RestfulApiTest extends PHPUnit_Framework_TestCase {

    protected $app;
    protected $user;
    protected $registerErrorMessage;    
    protected $saveErrorMessage;   
    protected $saveSuccessMessage;
    protected $updateSuccessMessage;    

    public function setUp() {                       

        global $env;
                
        $root = vfsStream::setup();
        $envFilePath = vfsStream::newFile('.env')->at($root);        
        $envFilePath->setContent($env);
        
        $this->app = (new App($root->url()))->get();        
        $this->user = TestDatabasePopulator::populate();
        $this->registerErrorMessage = 'Username or Password field not provided.';
        $this->saveErrorMessage = 'The supplied post data is not formatted correctly.';
        $this->saveSuccessMessage = 'Post created successfully.';
        $this->updateSuccessMessage = 'Post updated successfully.';
    }

    protected function get($url) {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => $url,
            ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        return $this->app->run(true);
    }

    protected function post($url, $body) {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI'    => $url,
            'CONTENT_TYPE'   => 'application/x-www-form-urlencoded',
        ]);
        $req = Request::createFromEnvironment($env)->withParsedBody($body);
        $this->app->getContainer()['request'] = $req;
        return $this->app->run(true);
    }   

    protected function postWithToken($url, $token, $body) {
        $env = Environment::mock([
            'REQUEST_METHOD'     => 'POST',
            'REQUEST_URI'        => $url,
            'HTTP_AUTHORIZATION' => 'Bearer '.$token,
            'CONTENT_TYPE'       => 'application/x-www-form-urlencoded',
        ]);
        $req = Request::createFromEnvironment($env)->withParsedBody($body);
        $this->app->getContainer()['request'] = $req;
        return $this->app->run(true);
    }

    protected function patchWithToken($url, $token, $body) {
        $env = Environment::mock([
            'REQUEST_METHOD'         => 'PATCH',
            'REQUEST_URI'            => $url,
            'X-HTTP-Method-Override' => 'PATCH',
            'HTTP_AUTHORIZATION'     => 'Bearer '.$token,
            'CONTENT_TYPE'           => 'application/x-www-form-urlencoded',
        ]);
        $req = Request::createFromEnvironment($env)->withParsedBody($body);
        $this->app->getContainer()['request'] = $req;
        return $this->app->run(true);
    }

    protected function deleteWithToken($url, $token)
    {
        $env = Environment::mock([
            'REQUEST_METHOD'         => 'DELETE',
            'REQUEST_URI'            => $url,
            'X-HTTP-Method-Override' => 'DELETE',
            'HTTP_AUTHORIZATION'     => 'Bearer '.$token,
            'CONTENT_TYPE'           => 'application/x-www-form-urlencoded',
        ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        return $this->app->run(true);
    }

    public function testPHPUnitWarningSuppressor() {
        $this->assertTrue(true);
    }

    protected function getLoginTokenForTestUser() {
        $response = $this->post('/auth/login', ['username' => "tester1", 'password' => "test"]);
        $result = json_decode($response->getBody(), true);        
        return $result['token'];
    }

}