# Restful API Example

This is a simple Restful API for Blog Service using the Slim Framework.

## Usage Clone this repository like so:

```
    git clone https://github.com/marcosricardoss/restful-api-slim-example.git
```

Change your directory to NaijaEmoji directory like so:

```
    cd restful-api-slim-example
```    

Install package dependencies:

```
    composer install
```    

You need set your environment variables to define your database parameters or rename .env.example file in project to .env and change the below to your local configuration.

```
    APP_SECRET=YourSecretKey 
    JWT_ALGORITHM=HS256
    [Database]
    driver=mysql
    host=127.0.0.1
    username=YourUsername
    password=YourPassword
    port=3306
    charset=utf8
    collation=utf8_unicode_ci
    database=YourDatabase
```

Finally, boot-up the API service with PHP's Built-in web server:

```    
    composer start
```    

All examples are shown in POSTMAN.

### Resgistration

You'd need to register as a user to manage posts. The /auth/register route handles user registration.

You can register a user using POSTMAN like so:

![User Registration](screenshots/screenshot_registration.png "User Registration")

Supply your preferred username and password

### Login

You need to get a token to use somes routes. The /auth/login route handles token generation for users. You can get token like so:

![User Login](screenshots/screenshot_login.png "User Login")

Use the returned token to make other requests to restricted routes.

### Get all Posts

To get all post, you send a `GET` request to `/posts` route like so:

![Get All Posts](screenshots/screenshot_get_all_posts.png "Get All Posts")

### Get a Post
To get an Post, you send a `GET` request to `/emoji/{id of post}` route like so:

![Get Post](screenshots/screenshot_get_a_post.png "Get Post")

### Search for Emojis
You can search for posts by the posts's `title`, `category` it belongs to and `keyword` associated to it. You can also get all posts `created by` a particular user.  
* `/posts/title/{post title}` to search for post by its `title`
* `/posts/category/{category name}` to search for posts that belongs to a `category`
* `/posts/keyword/{keyword name}` to search for posts that belongs to a `keyword`
* `/posts/createdBy/{creator name}` to search for posts created by a user

![Search Post](screenshots/screenshot_search_posts.png "Search Post")

### Create Post
To create a post, you send a `POST` request, with your authentication token, to `/posts` route with post's information like so:

![Create Post](screenshots/screenshot_create_post.png "Create Post")

### Delete Post
To delete an post, you send a `DELETE` request, with your authentication token, to `/posts/{id of post}` route like so:

![Delete Post](screenshots/screenshot_delete_post.png "Delete Post")

`Note: You can only delete a Post you created personally.`

## Update Post
To update post, you send a `PUT` or `PATCH` request, with your authentication token, to `/posts/{id of post}` route with the information you what to update like so:

![Update Post](screenshots/screenshot_update_post.png "Update Post")

`Note: You can only update a Post you created personally.`

### Credits

[Marcos Ricardo](https://github.com/marcosricardoss/)

### License

#### The MIT License (MIT)

Copyright (c) 2016 Marcos Ricardo <marcosricardoss@gmail.com>

> Permission is hereby granted, free of charge, to any person obtaining a copy
> of this software and associated documentation files (the "Software"), to deal
> in the Software without restriction, including without limitation the rights
> to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
> copies of the Software, and to permit persons to whom the Software is
> furnished to do so, subject to the following conditions:
>
> The above copyright notice and this permission notice shall be included in
> all copies or substantial portions of the Software.
>
> THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
> IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
> FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
> AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
> LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
> OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
> THE SOFTWARE.