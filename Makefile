start: stop
	docker-compose up -d --build app

stop:
	docker-compose down -v --remove-orphans

seed:
	docker-compose run --rm artisan migrate:refresh --path=app/Rating/Infrastructure/Database/Migrations --force
	docker-compose run --rm artisan db:seed --class=App\\Rating\\Infrastructure\\Database\\Seeders\\RatingSeeder

tinker:
	docker-compose run --rm artisan tinker

run_frontend:
	docker-compose run --rm --service-ports npm run start

build: build_backend build_frontend

build_backend: install clear_cache

install:
	docker-compose run --rm composer install --optimize-autoloader && \
	rm -f ./backend/.env && \
	cp ./backend/.env.example ./backend/.env && \
    docker-compose run --rm artisan key:generate

clear_cache:
	docker-compose run --rm artisan optimize:clear
	docker-compose run --rm composer dump-autoload

build_frontend:
	docker-compose run --rm npm install