# My portfolio

This is a pretty really simple portfolio that I made on 2015 just for show some
of my works.

I've used HTML, CSS (using Sass) & JS (using CoffeeScript) and a few lines of
PHP for send emails.

For the deployment I've created a docker instance with a custom image based on
php:apache where I've included composer.

The docker-compose just build it up, runs it and attach it to the nginx-proxy
docker external network that adds https support using letsencrypt and also
exposes it to internet.
