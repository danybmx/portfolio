FROM php:apache

RUN apt-get update
RUN apt-get install -y zip unzip curl git
