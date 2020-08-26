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
php artisan tinker
# add admin
```

```bash
php artisan db:seed --class=CategoryTableSeeder
php artisan db:seed --class=AuthorTableSeeder
```

- Use storage

```bash
php artisan storage:link
```
