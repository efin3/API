FROM escolalms/php:8.1-prod
WORKDIR /var/www/html
EXPOSE 80
COPY / /var/www/html
RUN apt install -y debian-keyring debian-archive-keyring apt-transport-https \
  && curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg \
  && curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | tee /etc/apt/sources.list.d/caddy-stable.list
RUN apt-get update && apt-get install caddy -y
RUN cp docker/envs/.env.postgres.example /var/www/html/.env \
  && cp docker/conf/supervisor/supervisord.conf /etc/supervisor/supervisord.conf \
  && cp docker/conf/supervisor/caddy.conf /etc/supervisor/custom.d/caddy.conf \
  && cp docker/conf/supervisor/scheduler.conf /etc/supervisor/custom.d/scheduler.conf \
  && cp docker/conf/supervisor/horizon.conf /etc/supervisor/custom.d/horizon.conf \
  && cp docker/conf/caddy/Caddyfile /etc/caddy/Caddyfile \
  && cp docker/conf/php/xxx-devilbox-default-php.ini /usr/local/etc/php/conf.d/xxx-devilbox-default-php.ini
RUN composer self-update && composer install --no-scripts
RUN chown -R devilbox:devilbox /var/www/

CMD php docker/envs/envs.php && /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
