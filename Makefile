run:
	docker run --rm -p 80:80 --name start.abendstille.at -v "$$PWD":/var/www/html php:7.2-apache