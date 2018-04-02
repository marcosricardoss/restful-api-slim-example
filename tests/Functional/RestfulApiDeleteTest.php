<?php

use Marcosricardoss\Restful\Model\User;

require_once 'RestfulApiTest.php';

class RestfulApiDeleteTest extends RestfulApiTest {

    public function testdeletePostWithIdReturnsStatusCode401WithMsgWhenUserTryDeletePostHeDoesNotCreate(){
        $post = User::where('id', '!=', $this->user->id)->first()->posts()->first();
        $token = $this->getLoginTokenForTestUser();
        $response = $this->deleteWithToken('/posts/'.$post->id, $token);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 401);
        $this->assertContains("You're not allowed to delete a post that you did not create.", $result);
    }

    public function testdeletePostWithIdReturnsStatusCode200WithMsg()  {
        $post = $this->user->posts()->first();
        $token = $this->getLoginTokenForTestUser();
        $response = $this->deleteWithToken('/posts/'.$post->id, $token);
        $result = (string) $response->getBody();
        $this->assertSame($response->getStatusCode(), 200);
        $this->assertContains('Post successfully deleted.', $result);
    }

}