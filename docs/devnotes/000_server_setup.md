# Server Setup & Requirements

1. Install docker
2. Install docker-compose (Optional when using an external DB / Queue driver)
3. npm run server:up 
4. npm run server:ssh
	- php artisan key:generate
    - chown -R www-data:www-data storage/
    - php artisan migrate 
6. Connect to DB, create trenchdevs database and setup sites table 
7. Setup cron (refer docs/crontab.txt)
