<?php

require_once 'RestfulApiTest.php';

class RestfulApiBaseTest extends RestfulApiTest {

    public function testGetAllPosts() {        
        $response = $this->get('/posts');        
        $data = json_decode($response->getBody(), true);        
        $this->assertSame($response->getStatusCode(), 200);        
    }

    public function testGetPostReturnsCorrectPostWithStatusCodeOf200() {
        $post = $this->user->posts()->first();
        $response = $this->get('/posts/'.$post->id);
        $data = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame($data['title'], $post->title);
        $this->assertSame($data['category'], $post->category->name);
    }

    public function testGetPostReturnsStatusCodeOf404WithMsgWhenPostWithPassedIdNotFound()
    {
        $response = $this->get('/posts/xxxx');
        $data = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 404);
        $this->assertSame($data['message'], 'The requested Post is not found.');
    }

    public function testRequestWithLoggedoutTokenReturnsStatusCode401WithMsg() {
        $response = $this->post('/auth/login', ['username' => 'tester1', 'password' => 'test']);
        $result = json_decode($response->getBody(), true);
        $token = $result['token'];
        $this->postWithToken('/auth/logout', $token, []);
        $post = $this->user->posts()->first();
        $postData = [
        'title'     => 'Slim Framework',
        'content'   => '__[:]__',
        'category'  => 'framwork'
        ];
        $response = $this->patchWithToken('/posts/'.$post->id, $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 401);
        $this->assertContains('Your token has been logged out.', $result);        
    }

    public function testSearchByTitle() {
        $title = 'Restful';
        $response = $this->get("/posts/title/$title");
        $data = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame($data[0]['title'], $title);        
    }

    public function testSearchByKeywordName() {
        $name = 'slim';
        $response = $this->get("/posts/keyword/$name");
        $data = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertArrayHasKey($name, array_flip($data[0]['keywords']));        
        $name = 'framework';
        $response = $this->get("/posts/keyword/$name");
        $data = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertArrayHasKey($name, array_flip($data[0]['keywords']));
    }

    public function testSearchByCategory() {
        $name = 'api';
        $response = $this->get("/posts/category/$name");
        $data = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame($name, $data[0]['category']);                
    }

    public function testSearchByCreator(){
        $name = 'tester1';
        $response = $this->get("/posts/createdBy/$name");
        $data = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame($name, $data[0]['created_by']);        
        $name = 'tester2';
        $response = $this->get("/posts/createdBy/$name");
        $data = (string) $response->getBody();
        $this->assertContains($name, $data);
        $this->assertSame($response->getStatusCode(), 200);
    }
    
    public function testGetReturnsStatusCode404WithMsgWhenRequestRouteDoesNotExit() {
        $response = $this->get('/xxxxxxx');
        $data = json_decode($response->getBody(), true);
        $this->assertSame($response->getStatusCode(), 404);
    }    

    public function testErrorHandlerReturnStatusCode401WhenExpiredExceptionThrown() {
        $handle = $this->app->getContainer()['errorHandler'];
        $response = $handle(null, new Slim\Http\Response(), new \Firebase\JWT\ExpiredException());
        $this->assertSame($response->getStatusCode(), 401);
    }

    public function testServerErrorLogs() {
        $handle = $this->app->getContainer()['errorHandler'];
        $response = $handle(null, new Slim\Http\Response(), new Exception());
        $this->assertSame($response->getStatusCode(), 500);        
        $response = $handle(null, new Slim\Http\Response(), new PDOException());
        $this->assertSame($response->getStatusCode(), 500);
    }
    
}