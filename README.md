# lampyno
LAMP Python NodeJS is based on the LAMP Docker platform I have adapted from here : 
https://github.com/GuillaumeIsabelleX/docker-compose-lamp/edit/master/README.md


# LAMP stack built with Docker Compose

![Landing Page](https://preview.ibb.co/gOTa0y/LAMP_STACK.png)

This is a basic LAMP stack environment built using Docker Compose. It consists following:

* PHP
* Apache
* MySQL
* phpMyAdmin
* NodeJS
* Python 



## Installation

Clone this repository on your local computer and checkout the appropriate branch e.g. 7.1.x. Run the `docker-compose up -d`.

```shell
git clone https://github.com/jgwill/lampyno.git
cd lampyno/
git fetch --all
docker-compose up -d
```

Your LAMP Python NodeJS stack is now ready!! You can access it via `http://localhost`.

## Configuration and Usage

Please read from appropriate version branch.



## Composing

Open a terminal and `cd` to the folder in which `docker-compose.yml` is saved and run:

```
docker-compose up
```

### Bash Alias
```bash
cat bashrc >~/.bashrc
```
* webs-bash, webs-restart,ws-restart,be-bash,be-restart, ...

## Usage



### Starting containers

You can start the containers with the `up` command in daemon mode (by adding `-d` as an argument) or by using the `start` command:

```
docker-compose start
```

### Stopping containers

```
docker-compose stop
```

### Removing containers

To stop and remove all the containers use the`down` command:

```
docker-compose down
```

Use `-v` if you need to remove the database volume which is used to persist the database:

```
docker-compose down -v
```

