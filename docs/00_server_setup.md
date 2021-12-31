# Server Setup & Requirements

1. Install docker
2. Install docker-compose (Optional when using an external DB / Queue driver)
3. npm run server:up 
4. npm run server:ssh
	- chown -R www-data:www-data storage/
	- php artisan migrate 
6. Connect to DB & Setup sites table 
7. Setup cron (refer docs/crontab.txt)
