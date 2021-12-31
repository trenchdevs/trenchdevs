# TrenchDevs Repo

Main source code for https://trenchdevs.org. TrenchDevs believes in outcome-based learning and adapting to different
technologies by creating purposeful projects.

For more information please refer the ["Launching TrenchDevs!!!"](https://blog.trenchdevs.org/launching-trenchdevs)
post.

## Installation

## Requirements

- Docker / Docker Compose

### Development Setup

1. Clone the repo: `git clone https://github.com/trenchdevs/trenchdevs.git`
2. Navigate to directory: `cd path/to/trenchdevs`
3. `npm run sever:up`
4. Clone and modify `backend/.env.example` to `backend/.env`
4. Clone and modify `.env.docker.example` to `.env` (Docker .env)
6. Connect to app container - `npm run server:ssh`
    1. Install composer dependencies: `composer install`
    2. Generate Laravel key: `php artisan key:generate`
    3. Generate JWT key: `php artisan jwt:secret`
    4. Migrate the database tables: `php artisan migrate`
    5. Initial Data: `php artisan db:seed`
    6. Initialize projects data: `php artisan utilities:execute initialize_project_data`
7. Navigate to any of the sites set on local
    - e.g. `trenchdevs.localhost`

Please contact us at support@trenchdevs.org for any additional instructions.

#### Running App in Docker

A Docker image for the app is hosted in [Docker hub](https://hub.docker.com/repository/docker/trenchdevs/trenchdevs). An
example for running the image in `docker` with MySQL is provided in this section. Before proceeding, make sure you have
ran through Quickstart. The `.env` generated will be needed for you to proceed. Instructions are tested in a linux
shell, but should be compatible with any other Posix compliant shell.

##### Requirements

- `docker`
- `docker-compose`
- Posix compliant shell

If you don't have mysql installed locally on your machine, you could run it using `docker-compose`. Do note that the
database instance used here will use `tmpfs` (in memory storage), stopping the service will delete data in MySQL.

```
$ docker-compose up db
```

Copy your `.env` file to `.env.docker`

```
$ cp .env .env.docker
```

Run the app with the following command:

```
$ docker run -p 8000:80 --env-file=.env.docker trenchdevs/trenchdevs
```

## Code of Conduct

In order to ensure that the TrenchDevs community is welcoming to all, please review and abide by the
[Code of Conduct](https://github.com/trenchdevs/trenchdevs/blob/master/CODE_OF_CONDUCT.md).

## Security Issues

For security issues, please send an email to Christopher Espiritu
via [christopheredrian@trenchdevs.org](mailto:christopheredrian@trenchdevs.org)
Security vulnerabilities will be addressed immediately.

## License

The TrenchDevs App is open-sourced software under
the [Apache-2.0 License](https://github.com/trenchdevs/trenchdevs/blob/master/LICENSE)
