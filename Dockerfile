FROM php:8.0-apache

RUN apt-get update && apt-get install
RUN service apache2 restart

EXPOSE 80