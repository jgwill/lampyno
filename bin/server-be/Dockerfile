#FROM mysql-server
FROM mariadb

RUN apt-get update
RUN apt-get install -y poppler-utils vim iputils-ping net-tools
RUN apt-get install mariadb-client -y

RUN mkdir -p -m 777 /var/lib/mysql

