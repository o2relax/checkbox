Тестове завдання (Backend Developer, PHP)
```text
Необхідно створити REST API для довідника книг.
Формат запитів/відповідей - json
1. Опис даних.
   a) Кожна книга повинна мати:
        1. Назва. (Обов'язкове поле)
        2. Короткий опис. (Необов'язкове поле)
        3. Зображення. (jpg або png, не більше 2 Мб, повинна зберігатися в окрему
           папку та мати унікальне ім'я файлу)
        4. Автори. (Обов'язкове поле може бути кілька авторів в однієї книги)
        5. Дата опублікування книги.
   b) У кожного автора мають бути:
        1. Прізвище (Обов'язкове поле, не коротше 3 символів)
        2. Ім'я (Обов'язкове)
        3. По-батькові (Необов'язкове)
2. API
   a) Роут для створення авторів
   b) Роут для перегляду списку всіх авторів
   c) Роут для створення книг
   d) Роут для перегляду списку всіх книг
   e) Роут для пошуку книг за прізвищем автора
   f) Роут для перегляду однієї книги
   g) Роут для редагування книги
   Примітка. При отриманні списку будь яких сутностей (авторів, книг) повинна
   використовуватись пагінація.
   Загальні положення.
   • Технології. Використовувати Symfony, PostgreSQL . Інші технології/фреймворки/
   бібліотеки можна брати на свій розсуд.
   • Створення таблиць БД реалізувати через механізм міграцій.
   • Те шо не вказано в вимогах до тестового завдання можна робити на свій розсуд.
   • Після виконання тестове завдання потрібно залити на репозиторій github із
   інструкцією для розгортання проекту та надати посилання.
```

P.S.: докер под веб сервер не делал, только база. openapi доку не делал. все в `/api.http`

Deployment
```shell
git clone
composer install
```
for DB:
```shell
docker compose up -d
```
```shell
symfony server:start_ OR php -S localhost:8080
```

