FROM fbraz3/lnmp:latest

COPY . /app/public

WORKDIR /app/public

RUN composer install
RUN sed -i 's/mysql < \/build.sql/mysqladmin -u root password "abc123" \&\& mysql -u root -pabc123 < \/build.sql/g' /docker-entrypoint.sh && \
    sed -i 's/^bind-address/# bind-address/' /etc/mysql/mariadb.conf.d/50-server.cnf && \
    echo "CREATE DATABASE app;" > /build.sql && \
    echo "create user chatphp identified by 'abc123';" >> /build.sql && \
    echo "grant all privileges on *.* to 'chatphp'@'%' identified by 'abc123' with grant option;" >> /build.sql && \
    echo "flush privileges;" >> /build.sql

EXPOSE 80 3306
