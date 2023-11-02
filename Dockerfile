FROM fbraz3/lnmp:latest

COPY . /app/public

WORKDIR /app/public

RUN composer install
RUN sed -i 's/mysql < \/build.sql/mysqladmin -u root password "abc123" \&\& mysql -u root -pabc123 < \/build.sql/g' /docker-entrypoint.sh && \
    echo "CREATE DATABASE app;" > /build.sql

EXPOSE 80 3306
