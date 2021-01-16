FROM 421972709577.dkr.ecr.us-east-1.amazonaws.com/base:php7.4-alpine

ADD . /var/www/app

COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf
COPY docker/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN cd /var/www/app && composer install --no-ansi && \
    php artisan migrate --force && chmod 777 -R /var/www/app/storage && chown -R nobody:nobody /var/www/app

RUN rm -rf /var/www/app/.git /var/www/app/docker* /var/www/app/local-environment

EXPOSE 80

WORKDIR /var/www/app

CMD ["/usr/bin/supervisord"]
