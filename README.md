# TrenchDevs Repo

Main source code for https://trenchdevs.org. TrenchDevs believes in outcome-based learning and adapting to different
technologies by creating purposeful projects.

## Installation

## Requirements

- Docker & Docker Compose  (Docker Desktop)
- Node JS LTS Version (Version 16 recommended)

### Development Setup

1. Clone the repo on your local
2. `cd /path/to/trenchdevs`
3. Initialize Everything: `npm run be:init`. This does the following 
   - Initializes .env variables for the root and the backend app
   - Creates the MySQL docker volume 
   - Builds the image 
   - Runs the app/db/mailhog using docker compose 
   - Install Composer dependencies
   - Migrations
   - Generate the app key 
   - Installs the front-end dependencies
4. Navigate to `http://trenchdevs.localhost:22061` and you should see the main trenchdevs site

Setup Tested on:

- Linux
- Mac
- Windows (via WSL2)

## Code of Conduct

In order to ensure that the TrenchDevs community is welcoming to all, please review and abide by the
[Code of Conduct](https://github.com/trenchdevs/trenchdevs/blob/master/CODE_OF_CONDUCT.md).

## Security Issues

For security issues, please email [christopheredrian@trenchdevs.org](mailto:christopheredrian@trenchdevs.org)
Security vulnerabilities will be addressed immediately.

## License

The TrenchDevs App is open-sourced software under
the [Apache-2.0 License](https://github.com/trenchdevs/trenchdevs/blob/master/LICENSE)
