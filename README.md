### Description
Project is a back-end RESTfull (with custom enhancements) API for car classified app.

### Technology:
- PHP8.2 + Laravel11 + MySQL8
- ElasticSearch to handle classified searching
- Horizon + Redis to handle time-consuming jobs
- Redis as a cache layer
- CI done with GitHub's workflows
- PSALM as static analysis tool (level 1)
- Pint as code style guard and fixer
- Laradock and Devbox for local development

### Local machine steps
- (assuming you are in automundo dir)
  cp .env.example .env
- (assuming you are in automundo/laradock dir)
  cp .env.example .env
- ```docker-compose up -d nginx mysql redis elasticsearch```
- ```docker exec -it automundo_workspace_1 bash```
- ```composer install```
- ```php artisan migrate```
- ```php artisan elasticsearch:index:recreate products```
- ```php artisan horizon```

### Horizon
Horizon is available on http://localhost/horizon

### Elasticsearch
Recreate index for products: ```php artisan elasticsearch:index:recreate products```

### Unit tests
```vendor/bin/phpunit```

### Endpoints (check: tests/Feature/Postman/AutoMundo.postman_collection.json)
- ```POST /register``` Register user
- ```POST /login``` Login user
- ```GET /profile``` Info about user
- ```GET /refresh-token``` Refresh token
- ```GET /logout``` Logout user
- ```POST /brands``` Add brand
- ```GET /brands/{id}``` Show brand
- ```GET /brands``` List brands
- ```POST /models``` Add model
- ```POST /products``` Add product
- ```GET /products/{id}``` Show product
- ```GET /products``` List products
