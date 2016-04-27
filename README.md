Пример реализаци REST API для статей на Yii2
============================
В данном примере реализовано простое REST API для статей. Написаны CRUD тест с использованием фикстур.
Тест проверяется дополнительно на соответствие документации.

ЗАВИСИМОСТИ
-----------

* PHP >= 5.4.0
* Composer
* Phing
* Ruby
* PostgreSQL >= 9.3


УСТАНОВКА
---------

1. Клонируем репозиторий
2. composer install
3. Меняем содержимое файла .env с настройками для подключения к БД
4. phing make-doc (генерация документации на swagger)

ВЕБ СЕРВЕР
---------

Для Apache

    # Set document root to be "basic/web"
    DocumentRoot "path/to/basic/web"

    <Directory "path/to/basic/web">
        # use mod_rewrite for pretty URL support
        RewriteEngine on
        # If a directory or a file exists, use the request directly
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        # Otherwise forward the request to index.php
        RewriteRule . index.php

        # ...other settings...
    </Directory>

Для Nginx:

    server {
        charset utf-8;
        client_max_body_size 128M;

        listen 80; ## listen for ipv4
        #listen [::]:80 default_server ipv6only=on; ## listen for ipv6

        server_name mysite.local;
        root        /path/to/basic/web;
        index       index.php;

        access_log  /path/to/basic/log/access.log;
        error_log   /path/to/basic/log/error.log;

        location / {
            # Redirect everything that isn't a real file to index.php
            try_files $uri $uri/ /index.php?$args;
        }

        # uncomment to avoid processing of calls to non-existing static files by Yii
        #location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
        #    try_files $uri =404;
        #}
        #error_page 404 /404.html;

        location ~ \.php$ {
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root/$fastcgi_script_name;
            fastcgi_pass   127.0.0.1:9000;
            #fastcgi_pass unix:/var/run/php5-fpm.sock;
            try_files $uri =404;
        }

        location ~ /\.(ht|svn|git) {
            deny all;
        }
    }

ЗАПУСК ТЕСТОВ
-------------

Для запуска тестов перейдите в папку `tests` и выполните команду `./run-tests`

ПРОСМОТР ДОКУМЕНТАЦИИ
-------------

Для просмотра документации перейдите по url - /doc/index.html