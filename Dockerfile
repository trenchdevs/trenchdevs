FROM ubuntu:20.04

RUN apt update
RUN apt-get install -y \
    nginx \
    php-fpm \
    php-mysql \
    php-xml \
    php7.4-zip


RUN apt-get install -y composer

RUN mkdir /var/www/trenchdevs
RUN chown -R $USER:$USER /var/www/trenchdevs

COPY ./docker/nginx/trenchdevs /etc/nginx/sites-available/trenchdevs
COPY . /var/www/trenchdevs

RUN ln -s /etc/nginx/sites-available/trenchdevs /etc/nginx/sites-enabled
RUN unlink /etc/nginx/sites-enabled/default

EXPOSE 80

CMD service nginx start && \
    service php7.4-fpm start && \
    exec /bin/bash -c "trap : TERM INT; sleep infinity & wait"

