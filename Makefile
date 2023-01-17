bash:
	docker exec -it notify_backend /bin/bash
up:
	docker-compose up
down:
	docker-compose down
build:
	make down
	docker-compose build
	make up
