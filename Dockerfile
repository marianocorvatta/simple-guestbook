FROM webdevops/php-nginx
EXPOSE 80
COPY . /app
RUN if test -d /app/Guestbook; then chmod 777 /app/Guestbook; fi
