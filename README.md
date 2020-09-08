# TrenchDevs Repo 

Main source code for https://trenchdevs.org. 
TrenchDevs believes in outcome-based learning and adapting to different technologies by creating purposeful projects.

For more information please refer the ["Launching TrenchDevs!!!"](https://blog.trenchdevs.org/launching-trenchdevs) post.

## Installation 

## Requirements 

- Php 7.4+
- MySQL (Preferably MySQL 8)
- composer (https://getcomposer.org)

### Quickstart

- Clone the repo: `git clone https://github.com/trenchdevs/trenchdevs.git`
- Navigate to directory: `cd trenchdevs`
- Install php dependencies: `composer install`
- Install npm dependencies: `npm install`
- Create database on MySQL: sql - `create database trenchdevs`
- Clone sample `.env` file: `cp .env.example .env`
- Modify `.env` for local system
- Generate Laravel key: `php artisan key:generate`
- Generate JWT key: `php artisan jwt:secret`
- Migrate the database tables: `php artisan migrate`
- Initial Data: `php artisan db:seed`
- Initialize projects data: `php artisan utilities:execute initialize_project_data`
- Start server: `php artisan serve`
- Using the default .env copied. On browser these two endponts should worl: 
    - `http://localhost:8000`
    - `blog.localhost:8000` 
- To sign in using the default user:
    - `http://localhost:8000/login`
    - email: `tcommerce@test.com`
    - password: `password`

Note: All file uploads and email **will not work by default**. Please contact us at support@trenchdevs.org to help
 you setup these features locally.  

## Code of Conduct 

In order to ensure that the TrenchDevs community is welcoming to all, please review and abide by the 
[Code of Conduct](https://github.com/trenchdevs/trenchdevs/blob/master/CODE_OF_CONDUCT.md).

## Security Issues

For security issues, please send an email to Christopher Espiritu via [christopheredrian@trenchdevs.org](mailto:christopheredrian@trenchdevs.org)
Security vulnerabilities will be addressed immediately.

## License 

The TrenchDevs App is open-sourced software under the [Apache-2.0 License](https://github.com/trenchdevs/trenchdevs/blob/master/LICENSE)
