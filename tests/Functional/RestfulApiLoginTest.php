<?php

require_once 'RestfulApiTest.php';

class RestfulApiLoginTest extends RestfulApiTest {

    public function testLoginReturnsTokenWhenValidUsernameAndPasswordIsPassed() {
        $response = $this->post('/auth/login', ['username' => 'tester1', 'password' => 'test']);
        $result = json_decode($response->getBody(), true);
        $this->assertNotNull($result['token']);
        $this->assertSame($response->getStatusCode(), 200);
    }

    public function testLoginReturnsStatusCode401WhenCorrectUsernameWithWrongPasswordIsPassed() {
        $response = $this->post('/auth/login', ['username' => 'tester1', 'password' => 'tes']);
        $result = json_decode($response->getBody(), true);
        $this->assertFalse(isset($result['token']));
        $this->assertSame($response->getStatusCode(), 401);
    }

    public function testLoginReturnsStatusCode401WhenIncorrectUsernameWithPasswordIsPassed(){
        $response = $this->post('/auth/login', ['username' => '@tester1', 'password' => 'tes']);
        $result = json_decode($response->getBody(), true);
        $this->assertFalse(isset($result['token']));
        $this->assertSame($response->getStatusCode(), 401);
    }
    
}