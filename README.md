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


### 2. Справка по всем методам в API
