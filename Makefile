up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose up -d --build

bash:
	docker compose exec php bash

go:
	docker compose exec php bash

m, migrate:
	docker compose exec php php artisan migrate

mr, rollback:
	docker compose exec php php artisan migrate:rollback

#seed:
#	docker compose exec php php artisan db:seed
#
#test:
#	docker compose exec php php artisan test tests/Unit  #--debug
#	docker compose exec php php artisan test tests/Feature  #--debug

composer:
	docker compose exec php composer install

setup: build composer migrate #seed
