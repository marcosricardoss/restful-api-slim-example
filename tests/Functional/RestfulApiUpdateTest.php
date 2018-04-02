<?php

use Marcosricardoss\Restful\Model\Post;
use Marcosricardoss\Restful\Model\User;

require_once 'RestfulApiTest.php';

class RestfulApiUpdatePostTest extends RestfulApiTest {
    
    public function testPatchRequestToUpdatePostWithIdReturnsStatusCode200WithMsgWhenPostDataIsPassed() {
        $post = $this->user->posts()->first();
        $postData = [
            'title'     => 'Post Test 1',
            'content'     => '__[:]__',
            'category' => 'category-1',
            'keywords' => ['key', 'words'],
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->patchWithToken('/posts/'.$post->id, $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertContains($this->updateSuccessMessage, $result);
        $post = $this->user->posts()->first();
        $this->assertEquals($postData['title'], $post->title);
    }    

    public function testPatchRequestToUpdatePostWithNewIdReturnsStatusCode201WithMsgWhenPostDataIsPassed() {
        $id = 1000;
        $postData = [
            'title'     => 'Post Created on Update',
            'content'     => '__[:]__',
            'category' => 'category-1',
            'keywords' => ['key', 'words'],
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->patchWithToken('/posts/'.$id, $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 201);
        $this->assertContains($this->saveSuccessMessage, $result);
        $post = Post::where('title', '=', 'Post Created on Update')->first();
        $this->assertEquals($post['title'], $post->title);
    }

    public function testPatchRequestToUpdateTitleWithIdReturnsStatusCode200WithMsgWhenOnlyTitleIsPassed() {
        $post = $this->user->posts()->first();
        $postData = [
            'title'     => 'Post Edited',
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->patchWithToken('/posts/'.$post->id, $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertContains($this->updateSuccessMessage, $result);
        $post = $this->user->posts()->first();
        $this->assertEquals($postData['title'], $post->title);
    }

    public function testPatchRequestToUpdateContentWithIdReturnsStatusCode200WithMsgWhenOnlyContentIsPassed() {
        $post = $this->user->posts()->first();
        $postData = [
            'content'     => 'Content Edited',
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->patchWithToken('/posts/'.$post->id, $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertContains($this->updateSuccessMessage, $result);
        $post = $this->user->posts()->first();
        $this->assertEquals($postData['content'], $post->content);
    }

    public function testUpdatePostWithIdReturnsStatusCode401WithMsgWhenUserTryUpdatePostHeDoesNotCreate() {
        $postByUserTwo = User::where('id', '!=', $this->user->id)->first()->posts()->first();
        $postData = [
            'title'        => 'Title XXX',
            'content'        => 'Content XXX',
        ];
        $token = $this->getLoginTokenForTestUser();
        $response = $this->patchWithToken('/posts/'.$postByUserTwo->id, $token, $postData);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 401);
        $this->assertContains("You're not allowed to update a post that you did not create.", $result);
    }   

}