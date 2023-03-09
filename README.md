## Test task to php(laravel)-dev position

Author Anna Borisenko

## Brief information about the project:

A small auction project has been created on the main page, filtering of lots by category has been implemented. Implemented the ability to create, edit and delete product categories and lots themselves.

## Instructions for checking this project:
  To check the functionality of the project, you need to clone the project:
```
git clone https://github.com/anutkaborisenko87/test_php_laravel_dev.git <project-directory>
```

and enter the following commands in sequence

```
cd <project-directory>

composer install

cp .env.example .env

php artisan key:generate
```
after the database for this project is created in MySQL and its settings are added to the .env file
```
php artisan migrate --seed

npm install

npm run dev

```
## Access rules
- a non-logged-in user can only sort lots by category on the main page and view prices
- if the user is registered and logged in, he can offer a new price for the lot he likes (higher than the one that already exists), he can also create his own lots, edit them and delete them
- admin, in turn, can create, edit and delete categories of lots

## Access to admin dasboard

- **login:** admin@admin.ua
- **password:** admin_admin_ua


- **link:** {your_domain}/admin

### Contacts

- **Linkedin: [Anna Borisenko](https://www.linkedin.com/in/anna-borisenko-695837213/)**
- **Telegram: [Anna Borisenko](https://t.me/AnutkaBorisenko)**
- **email: [anutkaborisenko87@gmail.com](anutkaborisenko87@gmail.com)**
