# My portfolio

This is a really really simple portfolio that I made on 2015 just for show some of my works.

It's done using HTML, CSS (using Sass) & JS (using CoffeeScript) and a few lines of PHP for send emails.

For the deployment it creates a docker instance with the php:apache image, run it and attach to my server
nginx-proxy container which adds https support using letsencrypt and exposes it to internet.
