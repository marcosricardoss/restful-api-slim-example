<?php

require_once 'RestfulApiTest.php';

class RestfulApiCreatePostTest extends RestfulApiTest {

    public function testCreatePostReturnsStatusCode201WithMsgWhenWellPreparedPostDataIsSent() {
        $postData = [
        'title'     => 'Post Test 1',
        'content'     => '__[:]__',
        'category' => 'category-1',
        'keywords' => ['key', 'words'],
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->postWithToken('/posts', $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 201);
        $this->assertContains($this->saveSuccessMessage, $result);
    }    

    public function testCreatePostReturnsStatusCode400WithMsgWhenPostDataIsSentWithEmptyTitleIsPassed() {
        $postData = [            
            'title'    => '',
            'content'  => '__[:]__',
            'category' => 'category-1',
            'keywords' => ['key', 'words'],
            ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->postWithToken('/posts', $token, $postData);
        $result = (string) $response->getBody();        
        $this->assertSame($response->getStatusCode(), 400);
        $this->assertContains($this->saveErrorMessage, $result);
    }
    
    public function testCreatePostReturnsStatusCode400WithMsgWhenPostDataIsSentWithoutTitle() {
        $postData = [            
            'content'     => '__[:]__',
            'category' => 'category-1',
            'keywords' => ['key', 'words'],
            ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->postWithToken('/posts', $token, $postData);
        $result = (string) $response->getBody();        
        $this->assertSame($response->getStatusCode(), 400);
        $this->assertContains($this->saveErrorMessage, $result);
    }   

    public function testCreatePostReturnsStatusCode200WithMsgWhenPostDataIsSentWithEmptyContentIsPassed() {
        $postData = [            
            'title'     => 'Post test 5',
            'content'   => '',
            'category' => 'category-1',
            'keywords' => ['key', 'words'],
            ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->postWithToken('/posts', $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 201);
        $this->assertContains($this->saveSuccessMessage, $result);
    }

    public function testCreatePostReturnsStatusCode201WithMsgWhenPostDataIsSentWithoutContent() {
        $postData = [
            'title'     => 'Post Test 1',
            'category' => 'category-1',                        
            'keywords' => ['key', 'words'],
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->postWithToken('/posts', $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 201);
        $this->assertContains($this->saveSuccessMessage, $result);
    }

    public function testCreatePostReturnsStatusCode201WithMsgWhenPostDataIsSentWithEmptyCategorytIsPassed() {
        $postData = [
            'title'     => 'Post Test 1',            
            'content'     => '__[:]__',
            'category' => '',                        
            'keywords' => ['key', 'words'],
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->postWithToken('/posts', $token, $postData);
        $result = (string) $response->getBody();        
        $this->assertSame($response->getStatusCode(), 201);
        $this->assertContains($this->saveSuccessMessage, $result);
    }     

    public function testCreatePostReturnsStatusCode201WithMsgWhenPostDataIsSentWithoutCategory() {
        $postData = [
            'title'     => 'Post Test 1',            
            'content'     => '__[:]__',
            'keywords' => ['key', 'words'],
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->postWithToken('/posts', $token, $postData);
        $result = (string) $response->getBody();        
        $this->assertSame($response->getStatusCode(), 201);
        $this->assertContains($this->saveSuccessMessage, $result);
    }         

    public function testCreatePostReturnsStatusCode201WithMsgWhenPostDataWithEmptyKeywordIsPassed() {
        $postData = [
        'title'     => 'Post Test 2',
        'content'     => '__[:]__',
        'category' => 'category-1',
        'keywords' => [''],
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->postWithToken('/posts', $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 201);
        $this->assertContains($this->saveSuccessMessage, $result);
    }   
    
    public function testCreatePostReturnsStatusCode201WithMsgWhenPostDataWithoutKeywords() {
        $postData = [
        'title'     => 'Post Test 2',
        'content'     => '__[:]__',
        'category' => 'category-1'        
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->postWithToken('/posts', $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 400);
        $this->assertContains($this->saveErrorMessage, $result);
    }       

}