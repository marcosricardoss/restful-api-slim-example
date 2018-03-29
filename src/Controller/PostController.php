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
     * Get a single post.
     *
     * @param Slim\Http\Request  $request
     * @param Slim\Http\Response $response
     * @param array              $args
     *
     * @return Slim\Http\Response
     */
    public function getPost($request, $response, $args) {
        $result = Post::withRelations()->find($args['id']);
        if (!$result) {
            return $response->withJson(['message' => 'The requested Post is not found.'], 404);
        }
        $res = $result->toArray();
        $res['keywords'] = array_map(function ($arr) { return $arr['name']; }, $res['keywords']);
        $res['category'] = $res['category']['name'];
        $res['created_by'] = $res['created_by']['username'];
        return $response->withJson($res);
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
     * Update single post.
     *
     * @param Slim\Http\Request  $request
     * @param Slim\Http\Response $response
     * @param array              $args
     *
     * @return Slim\Http\Response
     */
    public function update($request, $response, $args) {
        $user = $request->getAttribute('user');
        $post = $user->posts()->find($args['id']);
        if (!$post) {
            $post = Post::find($args['id']);
            if (!$post) {
                return $this->create($request, $response, $args);
            }
            throw new \DomainException("You're not allowed to update a post that you did not create.");
        }
        $post->update($request->getParsedBody());
        return $response->withJson(['message' => 'Post updated successfully.'], 200);
    }

    /**
     * Route for deleting a post.
     *
     * @param Slim\Http\Request  $request
     * @param Slim\Http\Response $response
     * @param array              $args
     *
     * @return Slim\Http\Response
     */
    public function delete($request, $response, $args) {
        $user = $request->getAttribute('user');
        $post = $user->posts()->find($args['id']);
        if (!$post) {
            throw new \DomainException("You're not allowed to delete a post that you did not create.");
        }
        $post->delete();
        return $response->withJson(['message' => 'Post successfully deleted.'], 200);
    }

    /**
     * Search for posts.
     *
     * @param Slim\Http\Request  $request
     * @param Slim\Http\Response $response
     * @param array              $args
     *
     * @return Slim\Http\Response
     */
    public function searchPost($request, $response, $args) {
        $result = $this->searchPostBy($args['field'], $args['search']);
        $this->formatPostDataForClient($result);
        return $response->withJson($result);
    }

     /**
     * Call appropriate post scope method for search.
     *
     * @param string $field
     * @param string $searchValue
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function searchPostBy($field, $searchValue) {       

        if ($field === 'title') {
            $result = Post::searchByTitle($searchValue)->get();
        } elseif ($field === 'keyword') {
            $result = Post::searchByKeywordName($searchValue)->get();
        } elseif ($field === 'createdBy') {            
            $result = Post::searchByCreatorName($searchValue)->get();
        } else {
            $result = Post::searchByCategoryName($searchValue)->get();
        }

        return $result;
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