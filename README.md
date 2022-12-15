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

**links**

[APP_URL/]()                 -here is the form
you need to enter token to add text

[APP_URL/lists]()         - here is the list of added texts

