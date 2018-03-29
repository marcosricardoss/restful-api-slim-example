<?php

namespace Marcosricardoss\Restful\Controller;

use Illuminate\Database\Capsule\Manager;

use Marcosricardoss\Restful\Helpers;
use Marcosricardoss\Restful\Model\User;
use Marcosricardoss\Restful\Model\Post;
use Marcosricardoss\Restful\Model\Category;
use Marcosricardoss\Restful\Model\Keyword;


final class PostController {


    /**
     * Fetch all posts.
     *
     * @param Slim\Http\Request  $request
     * @param Slim\Http\Response $response
     * @param array              $args
     *
     * @return Slim\Http\Response
     */
    public function getPosts($request, $response, $args) {
        $result = Post::withRelations()->get();        
        $this->formatPostDataForClient($result);

        return $response->withJson($result);
    }

    /**
     * Route for creating a post.
     *
     * @param Slim\Http\Request  $request
     * @param Slim\Http\Response $response
     * @param array              $args
     *
     * @return Slim\Http\Response
     */
    public function create($request, $response, $args)
    {
        $postData = $request->getParsedBody();
        if (!$postData || !$this->requiredPostDataAreProvided($postData)) {
            throw new \UnexpectedValueException('The supplied post data is not formatted correctly.');
        }        
        $user = $request->getAttribute('user');
        $this->createPost($postData, $user);
        
        return $response->withJson(['message' => 'Post created successfully.'], 201);
    }

    /**
     * Create a post in the database.
     *
     * @param array                              $postData
     * @param Marcosricardoss\Restful\Model\User $user
     *
     * @return void
     */
    private function createPost($postData, $user) {
        Manager::transaction(function () use ($postData, $user) {
            $category = Category::firstOrCreate(['name' => $postData['category']]);
            $post = new Post();
            $post->title = $postData['title'];
            $post->content = $postData['content'];
            $post->category_id = $category->id;
            $user->posts()->save($post);            
            $keywords = [];
            foreach ($postData['keywords'] as $key => $keyword) {
                $keyword = trim($keyword);
                # Skip empty keywords
                if (!$keyword) {
                    continue;
                }
                $keywordModel = Keyword::firstOrCreate(['name' => $keyword]);
                $keywords[] = $keywordModel->id;
            }
            $post->keywords()->attach($keywords);
        });
    }

    /**
     * Format post information return by Eloquent for API format.
     *
     * @param Illuminate\Database\Eloquent\Collection $emojiData
     *
     * @return void
     */
    private function formatPostDataForClient(&$postData){
        $postData = $postData->toArray();
        foreach ($postData as $key => &$res) {
            $res['keywords'] = array_map(function ($arr) { return $arr['name']; }, $res['keywords']);
            $res['category'] = $res['category']['name'];
            $res['created_by'] = $res['created_by']['username'];
        }
    }

    /**
     * * Validating post data.
     *
     * @param array $postData
     *
     * @return bool
     */
    private function requiredPostDataAreProvided($postData) {
        $requiredStrings = ['title','category'];
        if (!Helpers::keysExistAndNotEmptyString($requiredStrings, $postData)) {
            return false;
        }        
        return true;
    }
}