# Main Laravel Notes

## Laravel 

Five most important commands if your Laravel is not working as expected after some modifications in .env or 
database folder or because of any other modifications. Here is full explanation:
https://www.youtube.com/watch?v=Q1ynDMC8UGg

https://stackoverflow.com/questions/43243732/laravel-5-env-always-returns-null

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
composer dump-autoload
```


## VHOST Notes

```bash

# Apache
apachectl configtest
cd /etc/apache2/sites-available/
sudo a2ensite sjp.trenchdevs.org

sudo systemctl reload apache2
sudo apachectl restart
```

## Permissions

```bash

sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
sudo chmod -R 755 public
```


## Git Related

Executing a git pull from php does not work by default 
 
Action: `chmod o+rw -R .git`