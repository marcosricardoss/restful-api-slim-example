<?php
require_once 'RestfulApiTest.php';

class RestfulApiBaseTest extends RestfulApiTest {
    
    public function testGetReturnsStatusCode404WithMsgWhenRequestRouteDoesNotExit() {
        $response = $this->get('/xxxxxxx');
        $data = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 404);
    }    
    
}