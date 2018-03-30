<?php

use Illuminate\Database\Capsule\Manager as Capsule;

use Marcosricardoss\Restful\Model\User;
use Marcosricardoss\Restful\Model\Post;
use Marcosricardoss\Restful\Model\Category;
use Marcosricardoss\Restful\Model\Keyword;

class TestDatabasePopulator {

     /**
     * Create test post for test user.
     *
     * @param Marcosricardoss\Restful\Model\User $user
     *
     * @return void
     */
    private static function createPostOwnedBy($user) {
        $postData = [
        'title'     => 'Restful',
        'content'   => '__[::]__',
        'category'  => 'api',
        'keywords'  => ['slim', 'framework'],
        ];
        $category = Category::firstOrCreate(['name' => $postData['category']]);
        $post = new Post();
        $post->title = $postData['title'];
        $post->content = $postData['content'];
        $post->category_id = $category->id;
        $user->posts()->save($post);
        $keywords = self::createKeywords($postData['keywords']);
        $post->keywords()->attach($keywords);
    }

    /**
     * Create keywords.
     *
     * @param array $keywordsData
     *
     * @return array
     */
    private static function createKeywords($keywordsData) {
        $keywords = [];
        foreach ($keywordsData as $key => $keyword) {
            $keyword = trim($keyword);
                # Skip empty keywords
            if (!$keyword) {
                continue;
            }
            $keywordModel = Keyword::firstOrCreate(['name' => $keyword]);
            $keywords[] = $keywordModel->id;
        }
        return $keywords;
    }
    
    /**
     * Populate test Database with tests values.
     *
     * @return Pyjac\NaijaEmoji\Model\User
     */
    public static function populate()
    {
        Capsule::beginTransaction();
        try {
            $user1 = User::firstOrCreate([
                'username' => 'tester1'
            ], [
                'password' => password_hash('test', PASSWORD_DEFAULT),
                'role' => 'member'
            ]);
            $user2 = User::firstOrCreate([
                'username' => 'tester2'
            ], [
                'password' => password_hash('test', PASSWORD_DEFAULT),
                'role' => 'member'
            ]);            
            
            self::createPostOwnedBy($user1);
            self::createPostOwnedBy($user2);
            Capsule::commit();
            # all good
        } catch (\Exception $e) {
            Capsule::rollback();
            throw $e;
            # something went wrong
        }
        
        # create user
        return $user1;
    }
}