<?php
require_once 'RestfulApiTest.php';

class RestfulApiBaseTest extends RestfulApiTest {
    
    public function testGetReturnsStatusCode404WithMsgWhenRequestRouteDoesNotExit() {
        $response = $this->get('/xxxxxxx');
        $data = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 404);
    }    

    public function testServerErrorLogs() {
        $handle = $this->app->getContainer()['errorHandler'];
        $response = $handle(null, new Slim\Http\Response(), new Exception());
        $this->assertSame($response->getStatusCode(), 500);        
        $response = $handle(null, new Slim\Http\Response(), new PDOException());
        $this->assertSame($response->getStatusCode(), 500);
    }
    
}