### 1. Инструкцию по установке и настройке приложения.

#### Установка приложения

`git clone https://github.com/prgmr/utp.git`
`composer install --no-dev`

#### Настройка приложения

`cp .env.example .env`
Заполняем файл .env нужными данными, например

```
APP_NAME=App
APP_ENV=production
APP_DEBUG=false
DB_CONNECTION=sqlite
APP_URL=http://localhost
```

выполняем команды:

```
php artisan key:generate
php artisan migrate --seed
php artisan storage:link

php artisan user:create
php artisan test
```

`php artisan serve` - запуск приложения

### 2. Справка по всем методам в API

Регистрация пользователя  
Запрос

```
POST /api/v1/register  
name - string - имя учетной записи  
email - string - адрес электронной почты  
password - string - пароль  
```

Ответ

```
message - сообщение об успешной регистрации
error - информация об ошибках
```

Логин пользователя  
Запрос

```
POST /api/v1/login  
email - string - адрес электронной почты  
password - string - пароль  
```

Ответ

```
access_token - аутентификационный токен пользователя
error - информация об ошибках
```

Просмотр всех постов  
Запрос

```
GET /api/v1/posts?filter[title]=fuga&sort=id&order=desc&fields=content,title,id&page=1&per_page=3&expand=category
filter[title]=fuga - фильтрация по полю title
sort=id - сортировка по полю id
order=desc - сортировка по убыванию, по умолчанию asc
fields=content,title,id - вывод полей в ответе
page=1 - номер страницы, по умолчанию 1
per_page=3 - количество результатов на странице, по умолчанию 15
expand=category - вывод дополнительных полей
```

Ответ

```
{
  "data": [
    {
      "id": 15,
        ...
    }
  ],
  "links": {
    "first": "http:\/\/127.0.0.1:8000\/api\/v1\/posts?page=1",
    "last": "http:\/\/127.0.0.1:8000\/api\/v1\/posts?page=2",
    "prev": null,
    "next": "http:\/\/127.0.0.1:8000\/api\/v1\/posts?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 2,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "http:\/\/127.0.0.1:8000\/api\/v1\/posts?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": "http:\/\/127.0.0.1:8000\/api\/v1\/posts?page=2",
        "label": "2",
        "active": false
      },
      {
        "url": "http:\/\/127.0.0.1:8000\/api\/v1\/posts?page=2",
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "http:\/\/127.0.0.1:8000\/api\/v1\/posts",
    "per_page": 15,
    "to": 15,
    "total": 20
  }
}
```

Создание нового поста  
Запрос

```
POST /api/v1/posts
title - string - заголовок поста
content - string - содержание поста
author_id - integer - идентификатор автора
status  - integer - статус поста
```

Ответ

```
id - integer - идентификатор поста
created_at - string - дата создания записи
```

Посмотреть информацию о посте  
Запрос

```
GET /api/v1/posts/{post_id}?fields=title,content
post_id - идентификатор поста
fields=title,content - вывод полей
```

Ответ

```
id - integer - идентификатор поста
title - string - заголовок поста
content - string - содержание поста
author_id - integer - идентификатор автора
status  - integer - статус поста
created_at - string - дата создания поста
```

Обновить информацию поста  
Запрос

```
PUT /api/v1/posts/{post_id}
title - string - заголовок поста
content - string - содержание поста
author_id - integer - идентификатор автора
status  - integer - статус поста
```

Ответ

```
id - integer - идентификатор поста
updated_at - string - дата обновления поста
```

Удалить пост  
Запрос

```
DELETE /api/v1/posts/{post_id}
id - integer - идентификатор поста
```

Ответ

```
HTTP-ответ с кодом 204
```
