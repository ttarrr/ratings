start: stop
	docker-compose up -d --build app
	docker-compose run --rm --service-ports npm run start

stop:
	docker-compose down -v --remove-orphans

build: build_backend build_frontend

build_backend: install clear_cache

install:
	docker-compose run --rm composer install --optimize-autoloader

clear_cache:
	docker-compose run --rm artisan optimize:clear
	docker-compose run --rm composer dump-autoload

build_frontend:
	docker-compose run --rm npm install