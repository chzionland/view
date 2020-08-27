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

## How it was Built

- [Blog Web Site (Admin)](https://www.sheldonl.com/2020/08/08/00.md)

- [Blog Web Site (App Config)](https://www.sheldonl.com/2020/08/09/00.md)

- [Blog Web Site (CMS)](https://www.sheldonl.com/2020/08/11/00.md)

- [Blog Web Site (Front End)](https://www.sheldonl.com/2020/08/24/00.md)






