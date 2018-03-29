# Restful API Example

This is a simple Restful API for Blog Service using the Slim Framework.

##Usage Clone this repository like so:

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
    APP_SECRET=secretKey 
    JWT_ALGORITHM=HS256
    [Database]
    driver=mysql
    host=127.0.0.1
    username=username
    password=password
    port=3306
    charset=utf8
    collation=utf8_unicode_ci
    database=database
```

Finally, boot-up the API service with PHP's Built-in web server:

```    
    composer start
```    

All examples are shown in POSTMAN.
