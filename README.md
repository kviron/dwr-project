# DWR Project корпоротивный проект развертки сайта на wordpress Drozzi

## Особенности

- Улучшенная структура папок
- Управление зависимостями [Composer](https://getcomposer.org)
- Простая конфигурация WordPress с помощью env
- Переменные окружения с [Dotenv](https://github.com/vlucas/phpdotenv)
- Autoloader for mu-plugins (use regular plugins as mu-plugins)
- Enhanced security (separated web root and secure passwords
  with [wp-password-bcrypt](https://github.com/roots/wp-password-bcrypt))

## Зависимости

- PHP >= 7.1
- Composer - [Install](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

## Установка и создание проекта

1. Выполните команду для создания проекта:
   ```sh
   composer create-project kviron/dwr-project <project-name>
   ```
2. Обновите переменные в файле `.env`. Если значения имеют буквенно-цифровые значения, обязательно оборачивайте их в
   одинарные кавычки.

- Переменные настройки базы данных
    - `DB_NAME` - Имя базы данных
    - `DB_USER` - Пользователь базы данных
    - `DB_PASSWORD` - Пароль базы данных
    - `DB_HOST` - Хост базы данных
    - Если вы используете Docker как сервер в нем нужно обязательно указать имя контейнера базы данных например db
- `WP_ENV` - Переменначя режима работы сайта, может быть (`development`, `staging`, `production`)
- `WP_HOME` - Полный URL адрес до сайта WordPress (https://example.com)
- `WP_SITEURL` - Полный URL-адрес WordPress, включая подкаталог (https://example.com/wp)
- `AUTH_KEY`, `SECURE_AUTH_KEY`, `LOGGED_IN_KEY`, `NONCE_KEY`, `AUTH_SALT`, `SECURE_AUTH_SALT`, `LOGGED_IN_SALT`
  , `NONCE_SALT`
    - Генерируються по ссылке [wp-cli-dotenv-command](https://github.com/aaemnnosttv/wp-cli-dotenv-command)
    - Генерируються по ссылке [our WordPress salts generator](https://roots.io/salts.html)

3. Добавте вашу тему в `web/app/themes/` как и для обычного сайта WordPress
4. Установите корневой каталог документа на вашем веб-сервере в качестве базового `html` folder: `/path/to/site/html/`
5. Доступ к админке WordPress `https://example.com/wp/wp-admin/`

## Развертка локального сервера с помощью Docker

1. Что бы запустить локальный сервер на Docker нужно выполнить все шаги перечисленные выше и после выполнить команду

```sh
   docker-compose up --build -d
   ```

- В файле `.env` можно указать определенную конфигурацию сервера
    - `PROJECT_NAME` - устанавливает префикс к именам созданных контейнеров `example_db`, `example_phpmyadmin` и т.д.
    - `PHP_VER` - указывает какую версию php устанавливать на локальном сервере не рекомендуеться устанавливать весрию
      ниже 7.1
    - `PHP_PORT` - устанавливает на каком порту будет доступен наш проект, если вы используете по умолчанию 80 порт
      убедитесь, что данный порт свободен и не занят например программой OpenServer или другим ПО.
    - `PMA_PORT` - устанавливает на каком порту будет доступен phpmyadmin для доступа к базе данных сайта
    - `MYSQL_PORT` - устанавливает на каком порту будет доступен сервер базы данных
    - `MYSQL_ROOT_PASSWORD` - устанавливает пароль для root пользователя базы данных

## Установка плагинов и тем WordPress

Для того что бы установить любой плагин WordPress необходимо выполнить в корне проекта команду

```sh
composer require wpackagist-plugin/<plugin-name>
```

Для установки темы команда будет аналогична

```sh
composer require wpackagist-theme/<theme-name>
```

Так же вы можете загружать различные PHP пакеты расширений с [packagist.org](https://packagist.org/). В большинстве
случае ничего страшного не случиться, но мы не рекомендуем подключать зависимости packagist.org в корневом composer.json
Так как некоторые темы могут использовать анологичные зависимости внутри себя, и если в системе будет зарегистрирован
один и тот же пакет это вызовит фатальную ошибку.

Рекомендуеться все стороние PHP зависимости держать в `my-theme/composer.json`
и подключать внутри темы.

Файл `my-theme/functions.php`

```injectablephp
require __DIR__ . '/vendor/autoload.php'
```

## Особености использования проекта

### 1. Улучшенный дамп

В нашем проекте подключен удобный `var-dumper` от symfony. Все что нужно для его использования это вызвать функцию
`dump` примеры использования нативного дампа:

```injectablephp
var_dump($var);
```

Вместо использования нативного `var_dump` используйте функцию `dump`

```injectablephp
dump($var);
```

### 2. Быстрое создание дампа базы данных

Важная помарка, все файлы дампов базы данных нужно хранить в папке dumps
Есть два быстрых способа сделать дамп базы данных

####WP CLI

```sh
wp db export ./dumps/<file_name>.sql
```
На вашем сервере должен быть установлен WP CLI смотрите [инструкцию](https://wp-cli.org/)

####Docker

```sh
 docker exec <project_name>_db sh -c 'exec mysqldump --all-databases -uroot -p"$MYSQL_ROOT_PASSWORD"' > ./dumps/<file_name>.sql
```

Обратите внимание, example_db это только пример названия контейнера, вам нужно использовать свое имя контейнера по
такому шаблону `<project_name>_db` а так же нужно указать имя файла в который будет слит дамп базы данных

###Смена корневой папки проекта
Если вы хотите поменять корневую папку с `html` на свою. Вам потребуется  
- 1 - Переименовать папку `html` в ваше название
- 2 - Откройте файл `config/application.php` и поменяйте переменную `$webroot_dir` на свое название
- 3 - Откройте `composer.json` и поменяйте везде `html` на название своей папки