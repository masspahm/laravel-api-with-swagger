# Laravel API Documentation

# How to use
- git clone https://github.com/masspahm/laravel-api-with-swagger.git
- cd laravel-api-with-swagger
- composer install
- cp .env.example .env
- (adjust the configuration according to your postgresql server)
- php artisan key:generate
- php artisan db:seed
- php artisan serve
- now api server available at http://localhost:8000/api/v1
# try to login with dummy user:
- user : user@example.com
- password : userpassword
# API Documentation
- open http://localhost:8000/api/documentation
- authorize the api documentation using login token

# Logical test
- run php .\lexicographically.php on project root
