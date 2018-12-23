#BackEnd

##Main Requirements
- PHP > 7.2.9
- Laravel 5.7
- GIT
- Composer

##Tests

Run the following command from the root path of the application:
```
./vendor/bin/phpunit
```

Use test only after migration and seeding.  

##Deploy

1\. Run `php artisan serve`
```

3\. Set `.env` file configs:

3\.1 Create new database.

3\.2 Copy example config file: `cp .env.example .env`.

3\.3 Set DB name, DB user name and password in `.env` (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

3\.4 Set `APP_DEBUG=false` for production (`APP_ENV=production`) and `APP_DEBUG=true` for local (`APP_ENV=local`) environment.

4\. Execute the commands below:
```
composer install
```
```
php artisan key:generate
```
```
php artisan migrate
```

5\. Set `chmod 0777` for `/storage` and `/bootstrap` folders only if you have any troubles with access rights.

For example:
```
sudo chmod 0777 -R storage/
```

## Note

You should to configure server, to setup both front and pack apps, to work with one domain
