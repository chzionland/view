# README

This is a content management system build with PHP.

## How it was Built

- [Laravel Blog (Admin)](https://www.sheldonl.com/2020/08/08/00.html)

- [Laravel Blog (App Config)](https://www.sheldonl.com/2020/08/09/00.html)

- [Laravel Blog (CMS-Model)](https://www.sheldonl.com/2020/09/10/00.html)

- [Laravel Blog (CMS-Validation)](https://www.sheldonl.com/2020/09/10/01.html)

- [Laravel Blog (CMS-Routs, Controller and Storage)](https://www.sheldonl.com/2020/09/10/02.html)

- [Laravel Blog (CMS-View)](https://www.sheldonl.com/2020/09/10/03.html)

- [Laravel Blog (Front End)](https://www.sheldonl.com/2020/08/24/00.md)

## How to Deploy

- [Laravel Blog (Deployment)](https://www.sheldonl.com/2020/08/27/00.md)

## How to Run Locally

- Clone this repo `git clone git@github.com:chzionland/blog.git`;

- Install composer packages

```bash
cd view
composer install
npm install && npm run dev
```

- Create and setup `.env` file

```bash
cp .env.example .env
php artisan key:generate

# modify the database credential
```

- Migrate and insert records

```bash
php artisan migrate
```

```bash
php artisan db:seed --class=CategoryTableSeeder
php artisan db:seed --class=AuthorTableSeeder
```

```bash
php artisan tinker
```

```php
>>> factory(App\Admin::class, 1)->create();
>>> factory(App\Post::class, 100)->create();
>>> factory(App\CategoryPost::class, 100)->create();
```

- Use storage

```bash
php artisan storage:link
```

- Config

```bash
php artisan config:cache
```

- Mail setup
  - visit <htps://mailtrap.io/>
  - put laravel mail credentials in `.env` file

- Serve

```bash
php artisan serve
```
