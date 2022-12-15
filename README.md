## Start

`cp .env  .env.example`

```bash
composer install

php artisan migrate --seed

php artisan key:generate
```
get token :

`php  artisan to:auth admin password`

**Start via docker**

`make init`

get token : 

` docker-compose exec app-demo  php  artisan to:auth admin password`   



