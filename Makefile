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
open:
	open http://localhost:9325
	open http://localhost:8081
	open http://localhost:3000/api/doc
