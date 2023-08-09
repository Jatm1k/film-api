# Film API v0.9

Учебный проект на Laravel

## Используемые технологии:

* PHP
* Laravel

## Планируемый функционал:

- [x] CRUD фильмов
- [x] Авторизация/регистрация
- [x] Система ролей
- [x] Добавление фильмов в список просмотренного
- [x] Возможность писать обзоры для фильмов
- [x] Функционал оценки фильмов
- [x] Разделение фильмов по жанрам
- [x] Избранное
- [x] Группировка фильмов по категориям
- [x] Рекомендации фильмов
- [x] Система подписок на пользователей

## Установка:

1. Клонирование репозитория:
   `git clone https://github.com/Jatm1k/film-api.git`
2. Создание `.env` файла на основе `.env.example`
3. Настройка подключения к БД в созданном `.env`
4. Выполнение следующих команд для нормальной работы API:

```
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

## Документация:

Обозначения:

✅ - Для запроса нужна авторизация

🅰 - Для запроса нужны админ права

### Films

⚪ **Получение списка фильмов**

#### Запрос:

`GET /api/v1/films`

#### Ответ:

```
[
    {
        "id": 1,
        "title": "Id natus",
        "production_year": "1986",
        "duration": "14:30:00",
        "poster": "https://via.placeholder.com/300x450",
        "rating": {
            "value": 8,
            "count": 3
        },
        "genres": [
            {
                "id": 1,
                "name": "Qq"
            },
            {...}
        ]
    },
    {...},
]
```

---

⚪ **Получение списка популярных фильмов**

#### Запрос:

`GET /api/v1/films/popular`

#### Ответ:

```
[
    {
        "id": 1,
        "title": "Id natus",
        "production_year": "1986",
        "duration": "14:30:00",
        "poster": "https://via.placeholder.com/300x450",
        "rating": {
            "value": 8,
            "count": 3
        },
        "genres": [
            {
                "id": 1,
                "name": "Qq"
            },
            {...}
        ]
    },
    {...},
]
```

---

⚪ **Получение списка фильмов с большим рейтингом**

#### Запрос:

`GET /api/v1/films/big-rating`

#### Ответ:

```
[
    {
        "id": 1,
        "title": "Id natus",
        "production_year": "1986",
        "duration": "14:30:00",
        "poster": "https://via.placeholder.com/300x450",
        "rating": {
            "value": 8,
            "count": 3
        },
        "genres": [
            {
                "id": 1,
                "name": "Qq"
            },
            {...}
        ]
    },
    {...},
]
```

---

⚪ **Получение списка новых фильмов**

#### Запрос:

`GET /api/v1/films/new`

#### Ответ:

```
[
    {
        "id": 1,
        "title": "Id natus",
        "production_year": "1986",
        "duration": "14:30:00",
        "poster": "https://via.placeholder.com/300x450",
        "rating": {
            "value": 8,
            "count": 3
        },
        "genres": [
            {
                "id": 1,
                "name": "Qq"
            },
            {...}
        ]
    },
    {...},
]
```

---

⚪ **Получение списка рекомендаций** ✅

#### Запрос:

`GET /api/v1/films/recommendations`

#### Ответ:

```
[
    {
        "id": 1,
        "title": "Id natus",
        "production_year": "1986",
        "duration": "14:30:00",
        "poster": "https://via.placeholder.com/300x450",
        "rating": {
            "value": 8,
            "count": 3
        },
        "genres": [
            {
                "id": 1,
                "name": "Qq"
            },
            {...}
        ]
    },
    {...},
]
```

---

⚪ **Получение списка "смотрят друзья"** ✅

#### Запрос:

`GET /api/v1/films/subscriptions-watched`

#### Ответ:

```
[
    {
        "id": 1,
        "title": "Id natus",
        "production_year": "1986",
        "duration": "14:30:00",
        "poster": "https://via.placeholder.com/300x450",
        "rating": {
            "value": 8,
            "count": 3
        },
        "genres": [
            {
                "id": 1,
                "name": "Qq"
            },
            {...}
        ]
    },
    {...},
]
```

---

⬜ **Получение фильма**

#### Запрос:

`GET /api/v1/films/{id}`

#### Ответ:

```
{
    "id": 1,
    "title": "Qui",
    "production_year": "1993",
    "duration": "22:25:00",
    "poster": "https://via.placeholder.com/300x450",
    "images": [
        "https://via.placeholder.com/1920x1080",
        "https://via.placeholder.com/1920x1080",
        "https://via.placeholder.com/1920x1080"
    ],
    "trailer": null,
    "genres": [
        {
            "id": 1,
            "name": "Qq"
        },
        {...}
    ],
    "reviews": [
        {
            "id": 1,
            "title": "sit officiis est quo",
            "text": "Provident qui aliquam facilis ut id. Vel velit explicabo blanditiis quidem est qui vel. Tempora nam voluptatibus et modi.",
            "type": "negative",
            "author": {
                "id": 1,
                "name": "Голубев Эрик Александрович",
                "login": "natus",
                "email": "fokina.innokentii@example.org",
                "role": "viewer"
            }
        },
        {...}
    ],
    "rating": {
        "value": 4.5,
        "count": 4
    },
    "watch_with_it": [
        {
            "id": 14,
            "title": "Esse quis",
            "production_year": "2017",
            "duration": "09:29:00",
            "poster": "https://via.placeholder.com/300x450",
            "rating": {
                "value": 6,
                "count": 3
            },
            "genres": [
                {
                    "id": 1,
                    "name": "est"
                },
                {...}
            ]
        },
        {...}
    ]
}
```

---

⬜ **Получение фильма** ✅

#### Запрос:

`GET /api/v1/films/{id}`

#### Ответ:

```
{
    ...
    "watched": true,
    "my_rating": 8,
    "my_review": {
        "id": 1,
        "title": "sit officiis est quo",
        "text": "Provident qui aliquam facilis ut id. Vel velit explicabo blanditiis quidem est qui vel. Tempora nam voluptatibus et modi.",
        "type": "negative",
        "author": {
            "id": 1,
            "name": "Голубев Эрик Александрович",
            "login": "natus",
            "email": "fokina.innokentii@example.org",
            "role": "viewer"
        }
    }
}
```

---

🟢 **Добавление фильма в список просмотренного** ✅

#### Запрос:

`POST /api/v1/films/{id}/watch`

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Фильм добавлен в список просмотренного!"
}
```

---

🔴 **Удаление фильма из списка просмотренного** ✅

#### Запрос:

`DELETE /api/v1/films/{id}/unwatch`

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Фильм удален из списка просмотренного."
}
```

---

🟢 **Добавление фильма в избранное** ✅

#### Запрос:

`POST /api/v1/films/{id}/favorite`

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Фильм добавлен в избранное!"
}
```

---

🔴 **Удаление фильма из избранного** ✅

#### Запрос:

`DELETE /api/v1/films/{id}/unfavorite`

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Фильм удален из избранного."
}
```

---

🟢 **Создание фильма** ✅🅰

#### Запрос:

`POST /api/v1/films`

```
{
    "title": "Qui",
    "production_year": "1993",
    "duration": "02:25",
    "poster": IMAGE,
    "images": [IMAGES],
    "trailer": VIDEO,
}
```

#### Ответ:

```
{
    "id": 21,
    "title": "Qui",
    "production_year": "1993",
    "duration": "02:25",
    "poster": "http://localhost/storage/films/posters/H7rquZEOX1RZfw0xAQKswfMQqNCDlyI5fbWMGWjq.jpg",
    "images": [
        "http://localhost/storage/films/images/pefspp89MPNSgKSzkmTLYshKfS48gOZa14mLkke5.jpg",
        "http://localhost/storage/films/images/TcE9XCGMldUiLFe3znbAkQ5FfTMoxtPFchuzDxCv.jpg"
    ],
    "trailer": null,
    "reviews": [],
    "rating": {
        "value": 0,
        "count": 0
    },
    "watched": false,
    "my_rating": null,
    "my_review": null
}
```

---

🔵 **Редактирование фильма** ✅🅰

#### Запрос:

`PATCH /api/v1/films/{id}`

```
{
    "title": "Qui",
    "production_year": "1993",
    "duration": "02:25",
    "poster": IMAGE_URL/IMAGE_FILE,
    "images": [IMAGE_URLS/IMAGE_FILES],
    "trailer": VIDEO,
}
```

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Информация сохранена!"
}
```

---

🔴 **Удаление фильма** ✅🅰

#### Запрос:

`DELETE /api/v1/films/{id}`

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Успешно удалено!"
}
```

### Аутентификация

❗❗❗ **ВАЖНО** ❗❗❗

Для аутентификации необходимо получить `XSRF-TOKEN` отправив запрос `GET /sanctum/csrf-cookie`

Пример:

```
axios.get('/sanctum/csrf-cookie').then(response => {
    // Login...
});
```

🟢 **Авторизация**

#### Запрос:

`POST /login`

```
{
    "login": "natus",
    "password": "password"
}
```

#### Ответ:

```
{
    "id": 1,
    "name": "Голубев Эрик Александрович",
    "login": "natus",
    "email": "fokina.innokentii@example.org",
    "role": "viewer",
    "subscriptions": [],
    "subscribers": [],
    "watched_films": [],
    "reviews": []
}
```

---

🟢 **Регистрация**

#### Запрос:

`POST /register`

```
{
    "name": "Голубев Эрик Александрович",
    "login": "natus",
    "email": "fokina.innokentii@example.org",
    "password": "password",
    "password_confirmation": "password"
}
```

#### Ответ:

```
{
    "id": 1,
    "name": "Голубев Эрик Александрович",
    "login": "natus",
    "email": "fokina.innokentii@example.org",
    "role": "viewer",
    "subscriptions": [],
    "subscribers": [],
    "watched_films": [],
    "reviews": []
}
```

---

🔴 **Удаление сессии(logout)**

#### Запрос:

`DELETE /logout`

### Reviews

🟢 **Создание обзора** ✅

#### Запрос:

`POST /api/v1/reviews`

```
{
    "film_id": 1,
    "title": "sit officiis est quo",
    "text": "Provident qui aliquam facilis ut id. Vel velit explicabo blanditiis quidem est qui vel. Tempora nam voluptatibus et modi.",
    "type": "negative" / "positive"
}
```

#### Ответ:

```
{
    "id": 1,
    "title": "sit officiis est quo",
    "text": "Provident qui aliquam facilis ut id. Vel velit explicabo blanditiis quidem est qui vel. Tempora nam voluptatibus et modi.",
    "type": "negative",
    "film": {
        "id": 1,
        "title": "Qui",
        "production_year": "1993",
        "duration": "22:25:00",
        "poster": "https://via.placeholder.com/300x450",
        "rating": {
            "value": 5.2,
            "count": 5
        }
    },
    "author": {
        "id": 1,
        "name": "Голубев Эрик Александрович",
        "login": "natus",
        "email": "fokina.innokentii@example.org",
        "role": "viewer"
    }
}
```

---

🔵 **Редактирование обзора** ✅

#### Запрос:

`PATCH /api/v1/reviews/{id}`

```
{
    "title": "sit officiis est quo",
    "text": "Provident qui aliquam facilis ut id. Vel velit explicabo blanditiis quidem est qui vel. Tempora nam voluptatibus et modi.",
    "type": "positive"
}
```

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Информация сохранена!"
}
```

---

🔴 **Удаление обзора** ✅

#### Запрос:

`DELETE /api/v1/reviews/{id}`

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Успешно удалено!"
}
```

### Ratings

🟢 **Создание оценки** ✅

#### Запрос:

`POST /api/v1/ratings`

```
{
    "film_id": 1,
    "rating": 7
}
```

#### Ответ:

```
{
    "id": 1,
    "film": {
        "id": 1,
        "title": "Qui",
        "production_year": "1993",
        "duration": "22:25:00",
        "poster": "https://via.placeholder.com/300x450",
        "rating": {
            "value": 5.6,
            "count": 5
        }
    },
    "author": {
        "id": 1,
        "name": "Голубев Эрик Александрович",
        "login": "natus",
        "email": "fokina.innokentii@example.org",
        "role": "viewer"
    },
    "rating": "7"
}
```

---

🔵 **Редактирование оценки** ✅

#### Запрос:

`PATCH /api/v1/ratings/{id}`

```
{
    "rating": 10
}
```

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Информация сохранена!"
}
```

---

🔴 **Удаление оценки** ✅

#### Запрос:

`DELETE /api/v1/ratings/{id}`

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Успешно удалено!"
}
```

### AuthUser

⚪ **Получение списка просмотренных фильмов** ✅

#### Запрос:

`GET /api/v1/watched`

#### Ответ:

```
[
    {
        "id": 1,
        "title": "Qui",
        "production_year": "1993",
        "duration": "22:25:00",
        "poster": "https://via.placeholder.com/300x450",
        "rating": {
            "value": 5.4,
            "count": 5
        }
    },
    {...},
]
```

---

⚪ **Получение списка обзоров на фильмы** ✅

#### Запрос:

`GET /api/v1/my-reviews`

#### Ответ:

```
[
    {
        "id": 2,
        "title": "veritatis fuga eum",
        "text": "Quos eligendi nihil beatae suscipit eaque animi sunt. Dignissimos molestias architecto sed. Laudantium provident qui et officiis consequatur voluptatem. Cumque sit fugit qui voluptate id fugiat quis.",
        "type": "positive",
        "film": {
            "id": 2,
            "title": "Et enim sit",
            "production_year": "2017",
            "duration": "18:42:00",
            "poster": "https://via.placeholder.com/300x450",
            "rating": {
                "value": 4.3,
                "count": 4
            }
        },
        "author": {
            "id": 1,
            "name": "Голубев Эрик Александрович",
            "login": "natus",
            "email": "fokina.innokentii@example.org",
            "role": "viewer"
        }
    },
    {...},
]
```

### Genres

🟢 **Создание жанра** ✅🅰

#### Запрос:

`POST /api/v1/genres`

```
{
    "name": "Lorem"
}
```

#### Ответ:

```
{
    "id": 11,
    "name": "Lorem",
    "films_count": 0,
    "films": []
}
```

---

🔵 **Редактирование жанра** ✅🅰

#### Запрос:

`PATCH /api/v1/genres/{id}`

```
{
    "name": "Qui"
}
```

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Информация сохранена!"
}
```

---

🔴 **Удаление жанра** ✅🅰

#### Запрос:

`DELETE /api/v1/genres/{id}`

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Успешно удалено!"
}
```

---

⚪ **Получение списка жанров**

#### Запрос:

`GET /api/v1/genres`

#### Ответ:

```
[
    {
        "id": 1,
        "name": "Qq"
    },
    {...},
]
```

---

⬜ **Получение жанра**

#### Запрос:

`GET /api/v1/films/{id}`

#### Ответ:

```
{
    "id": 1,
    "name": "Qq",
    "films_count": 9,
    "films": [
        {
            "id": 1,
            "title": "Similique aliquam",
            "production_year": "1979",
            "duration": "00:08:00",
            "poster": "https://via.placeholder.com/300x450",
            "rating": {
                "value": 7.5,
                "count": 12
            }
        },
        {...}
    ]
}
```

### Users

⬜ **Просмотр профиля пользователя**

#### Запрос:

`GET /api/v1/users/{id}`

#### Ответ:

```
{
    "id": 1,
    "name": "Аксёнова Альбина Романовна",
    "login": "vitae",
    "email": "qfokin@example.org",
    "role": "admin",
    "subscriptions": [
         {
            "id": 2,
            "name": "Русакова Дан Борисович",
            "login": "tempore",
            "role": "viewer"
        },
        {...}
    ],
    "subscribers": [
         {
            "id": 2,
            "name": "Русакова Дан Борисович",
            "login": "tempore",
            "role": "viewer"
        },
        {...}
    ],
    "watched_films": [
        {
            "id": 1,
            "title": "Ea autem amet",
            "production_year": "1975",
            "duration": "14:10:00",
            "poster": "https://via.placeholder.com/300x450",
            "rating": {
                "value": 7,
                "count": 4
            },
            "genres": [
                {
                    "id": 2,
                    "name": "eius"
                },
                {...}
            ]
        },
        {...}
    ],
    "reviews": [
        {
            "id": 1,
            "title": "doloribus aut suscipit dolor",
            "text": "Eum quos sed doloribus magni. Enim qui iste est dolor deleniti. Minus aut et a non.",
            "type": "positive",
            "author": {
                "id": 1,
                "name": "Аксёнова Альбина Романовна",
                "login": "vitae",
                "role": "admin"
            }
        },
        {...}
    ]
}
```

---

🟢 **Подписка на пользователя** ✅

#### Запрос:

`POST /api/v1/users/{id}`

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Теперь вы подписаны на vero"
}
```

---

🔴 **Отписка от пользователя** ✅

#### Запрос:

`DELETE /api/v1/users/{id}`

#### Ответ:

```
{
    "status": "Успешно",
    "message": "Вы отписались от vero"
}
```

---