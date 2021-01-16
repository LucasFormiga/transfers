FROM 421972709577.dkr.ecr.us-east-1.amazonaws.com/base:php7.4-alpine

EXPOSE 80

RUN adduser app -shell /bin/sh --disabled-password --uid 1000

WORKDIR /var/www/app

CMD ["/usr/bin/supervisord"]
