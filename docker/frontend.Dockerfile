FROM nginx:1.27.1 AS web

RUN rm /etc/nginx/conf.d/default.conf

WORKDIR /var/www/app

COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
