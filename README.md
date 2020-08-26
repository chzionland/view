## How to Run Locally

- Clone this repo `git clone git@github.com:chzionland/blog.git`;

- Install composer packages

```bash
cd blog
composer install
npm install && npm run dev
```

- Create adn setup `.env` file

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
php artisan tinker
```

```php
>>> factory(App\User::class, 5)->create();
>>> factory(App\Post::class, 100)->create();
>>> exit
```

```bash
php artisan db:seed --class=CategoriesTableSeeder

```

```bash
php artisan tinker
```

```php
>>>factory(App\CategoryPost::class, 100)->create();
```

- Use storage

```bash
php artisan storage:link
```

- Mail setup
    - visit <htps://mailtrap.io/>
    - put laravel mail credentials in `.env` file

## History Versions

- This is the first version (v_1.0), the features:
    - Admin login
    - Admin can manage galleries, posts, categories, and pages
