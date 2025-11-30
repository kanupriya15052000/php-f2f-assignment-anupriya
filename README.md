# PHP/Laravel Assignment – JWT + Add to Cart API

## Features Implemented
- JWT Authentication (Register, Login, Me)
- Add Product to Cart API
- Cart + Cart Items tables
- Product Seeder for testing
- Postman testing for all endpoints

## Endpoints
POST /api/register  
POST /api/login  
POST /api/cart/add  (Protected using JWT)

## How to run
1. composer install
2. cp .env.example .env
3. Update DB settings
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed --class=ProductSeeder
7. php artisan jwt:secret
8. php artisan serve

