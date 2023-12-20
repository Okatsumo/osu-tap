# fetch the Composer image, image page: <https://hub.docker.com/_/nginx>
FROM nginx:stable-alpine as composer

RUN set -x \
        && adduser \
              --disabled-password \
             --shell "/sbin/nologin" \
             --home "/nonexistent" \
             --no-create-home \
             --uid "10001" \
             --gecos "" \
             "appuser" \
        && mkdir -p /app \
        && chown -R appuser:appuser /app \
        && mkdir /etc/nginx/logs/ \
        && chown -R appuser:appuser /etc/nginx/logs/

# use an unprivileged user by default
USER appuser:appuser
ARG nginx_uid=$APP_UID
ARG nginx_gid=$APP_GID

# use directory with application sources by default
WORKDIR /app

# import nginx config file
ADD ./nginx/nginx.conf /etc/nginx/
