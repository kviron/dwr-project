
# Drozzi Wordpress Project
Проект для быстрой развертки сайта на wordpress с помощью composer.
Проект возможно развернуть как на любом сервере AMPP так и через контейнер Docker встроенный в проект.

## Параметры проекта

+ PHP 7.4
+ [Bedrock](https://roots.io/bedrock/) - улучшеная структура Wordpress проекта
+ [Composer](https://getcomposer.org/) - Пакетный менеджер для php
+ [WP-CLI](https://wp-cli.org/) - WP-CLI консоль для управления сайтом на Wordpress
+ [Docker](https://www.docker.com/get-started) - Контейниризация проекта для упрощеной развертки сложного проекта

## Установка

Создаем пустую папку проекта в любом месте и открываем в ней терминал, после нам нужно выполнить команду
```shell
composer create-project kviron/dwr-project .
```

Данная команда развернет самую последнию версию Wordpress, создаст файл переменных окружения .env и установит самые важные и часто используемые плагины для wordpress


 ## Настройка конфигов
 В данном проекто есть только два файла отвечающих за конфиги.
 `.env` в корне проекта и
 `./public_html/app/themes/имя_темы/.env` отвечающий за конфиги webpack

### Настройка конфигов проекта (.env в корне)
Первая секция это настройка доступов к базе данных
```
## MySQL configs
DB_NAME=dwr-project
DB_USER=dwr-project
DB_PASSWORD=dwr-project
DB_ROOT_PASS=root
DB_PORT=3306
DB_HOST=localhost
# DB_PREFIX='wp_'
# DATABASE_URL='mysql://database_user:database_password@database_host:database_port/database_name'
```

Если вы разворачиваете проект через Docker контейнер, то в параметр DB_HOST нужно будет указать имя контейнера базы данных

#### 3. Here settings for the Wordpress
```dotenv
WP_ENV=dev
WP_HOME=http://myapp.local
WP_SITEURL=${WP_HOME}/wp
WP_DEBUG_LOG=/path/to/debug.log
WP_POST_REVISIONS=5
WP_LANG=ru_RU
FS_METHOD=direct
```
<details>
 <summary>Install with Docker</summary>

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

3. Install project

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

## PhpMyAdmin

PhpMyAdmin comes installed as a service in docker-compose.

🚀 Open [http://127.0.0.1:8082/](http://127.0.0.1:8082/) in your browser

## MailHog

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
