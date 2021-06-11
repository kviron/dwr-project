
# Docker Compose and WordPress

Use WordPress locally with Docker using [Docker compose](https://docs.docker.com/compose/)

## Contents

+ A `Dockerfile` for extending a base image and using a custom [Docker image](https://github.com/urre/wordpress-nginx-docker-compose-image) with an [automated build on Docker Hub](https://cloud.docker.com/repository/docker/urre/wordpress-nginx-docker-compose-image)
+ PHP 7.4
+ Custom domain for example `myapp.local`
+ Custom nginx config in `./nginx`
+ Custom PHP `php.ini` config in `./config`
+ Volumes for `nginx`, `wordpress` and `mariadb`
+ [Bedrock](https://roots.io/bedrock/) - modern development tools, easier configuration, and an improved secured folder structure for WordPress
+ Composer
+ [WP-CLI](https://wp-cli.org/) - WP-CLI is the command-line interface for WordPress.
+ [MailHog](https://github.com/mailhog/MailHog) - An email testing tool for developers. Configure your outgoing SMTP server and view your outgoing email in a web UI.
+ [PhpMyAdmin](https://www.phpmyadmin.net/) - free and open source administration tool for MySQL and MariaDB
	- PhpMyAdmin config in `./config`

## Instructions

<details>
 <summary>Requirements</summary>

+ [Docker](https://www.docker.com/get-started)

</details>

<details>
 <summary>Setup</summary>

 ### Setup Environment variables

Copy `.env.example` in the project root to `.env` and edit your preferences.

#### 1. For Docker like Server

Example:

```dotenv
IP=127.0.0.1
APP_NAME=myapp
DOMAIN=myapp.local
DB_ROOT_PASSWORD=password
```

#### 2. For local server (OpenServer, XAMP ....)
Example:

```dotenv
DB_HOST=localhost
DB_NAME=myapp
DB_USER=root
DB_PASSWORD=password

# Generate your keys here: https://roots.io/salts.html
AUTH_KEY='generateme'
SECURE_AUTH_KEY='generateme'
LOGGED_IN_KEY='generateme'
NONCE_KEY='generateme'
AUTH_SALT='generateme'
SECURE_AUTH_SALT='generateme'
LOGGED_IN_SALT='generateme'
NONCE_SALT='generateme'
```

</details>

<details>
 <summary>If you using Docker compose for server</summary>

1. Edit `nginx/default.conf.conf` to change the nginx server settings

```shell
server {
    listen 80;

    root /var/www/html/web;
    index index.php;

    access_log /var/log/nginx/access.log;
    error_log /var/log/nginx/error.log;

    client_max_body_size 100M;

    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass wordpress:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }
}

```

2. Edit the nginx service in `docker-compose.yml` to use any port (default 80)

```shell
  nginx:
    image: nginx:latest
    container_name: ${APP_NAME}-nginx
    ports:
      - '80:80'

```

3. Continue on the Install step below

</details>

<details>
 <summary>Install with docker</summary>

```shell
docker-compose run composer create-project
```

</details>

<details>
 <summary>Run with docker</summary>

```shell
docker-compose up
```

Docker Compose will now start all the services for you:

```shell
Starting myapp-mysql    ... done
Starting myapp-composer ... done
Starting myapp-phpmyadmin ... done
Starting myapp-wordpress  ... done
Starting myapp-nginx      ... done
Starting myapp-mailhog    ... done
```

🚀 Open [http://myapp.local](http://myapp.local) in your browser

## PhpMyAdmin (Docker)

PhpMyAdmin comes installed as a service in docker-compose.

🚀 Open [http://127.0.0.1:8082/](http://127.0.0.1:8082/) in your browser

## MailHog (Docker)

MailHog comes installed as a service in docker-compose.

🚀 Open [http://0.0.0.0:8025/](http://0.0.0.0:8025/) in your browser

</details>

## Tools

### Update WordPress Core and Composer packages (plugins/themes)

whit Docker
```shell
docker-compose run composer update
```

with composer
```shell
composer reuqire wpackagist-plugin/plugin-name
composer reuqire wpackagist-theme/theme-name
```

#### Use WP-CLI only with DOcker
```shell
docker exec -it myapp-wordpress bash
```

Login to the container

```shell
wp search-replace https://olddomain.com https://newdomain.com --allow-root
```

Run a wp-cli command

> You can use this command first after you've installed WordPress using Composer as the example above.

### Update plugins and themes from wp-admin?

You can, but I recommend to use Composer for this only. But to enable this edit `./config/environments/development.php` (for example to use it in Dev)

```shell
Config::define('DISALLOW_FILE_EDIT', false);
Config::define('DISALLOW_FILE_MODS', false);
```

### Useful Docker Commands

When making changes to the Dockerfile, use:

```bash
docker-compose up -d --force-recreate --build
```

Login to the docker container

```shell
docker exec -it myapp-wordpress bash
```

Stop

```shell
docker-compose stop
```

Down (stop and remove)

```shell
docker-compose down
```

Cleanup

```shell
docker-compose rm -v
```

Recreate

```shell
docker-compose up -d --force-recreate
```

Rebuild docker container when Dockerfile has changed

```shell
docker-compose up -d --force-recreate --build
```
