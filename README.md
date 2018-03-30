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

## Resgistration

You'd need to register as a user to manage posts. The /auth/register route handles user registration.

You can register a user using POSTMAN like so:

![User Registration](screenshots/screenshot_registration.png "User Registration")

Supply your preferred username and password

## Credits

[Marcos Ricardo](https://github.com/marcosricardoss/)

## License

### The MIT License (MIT)

Copyright (c) 2016 Oyebanji Jacob <oyebanji.jacob@andela.com>

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