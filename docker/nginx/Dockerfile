FROM nginx:1.13

COPY ./nginx.conf /etc/nginx/
COPY ./default.conf /etc/nginx/conf.d/

RUN usermod -u 1000 www-data
