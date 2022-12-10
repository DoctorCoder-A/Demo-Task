ENV_EXAMPLE_FILE=.env.example
ENV_FILE=.env
init: check-env docker-down-clear docker-build docker-up app-init
start:docker-down-clear docker-up
down:docker-down-clear
check-env:
	@if [ ! -f "${ENV_FILE}" ]; then\
        	cp ${ENV_EXAMPLE_FILE} ${ENV_FILE};\
	fi
docker-build:
	docker-compose build
docker-up:
	docker-compose up -d
docker-down-clear:
	docker-compose down -v --remove-orphans
app-init:docker-composer-install docker-artisan-seed
docker-composer-install:
	docker-compose exec app-demo composer install
docker-artisan-seed:
	docker-compose exec app-demo php artisan migrate --seed
docker-db-bash:
	docker-compose exec db-demo bash
