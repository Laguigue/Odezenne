# Odezenne project [![Build Status](https://travis-ci.org/ecvdbdx1617/Odezenne.svg?branch=master)](https://travis-ci.org/ecvdbdx1617/Odezenne) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/e98066734dbe435d959c3388f61bdb38)](https://www.codacy.com/app/bramvanosta/Odezenne?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ecvdbdx1617/Odezenne&amp;utm_campaign=Badge_Grade)

## Includes
- [Wordpress REST API](http://v2.wp-api.org/) with MariaDB database
- [Lumen](https://lumen.laravel.com/) API with MariaDB database
- [Vue.js](https://vuejs.org/) client

## Dependencies
- [Docker](https://docs.docker.com/engine/installation/) & [Docker-compose](https://docs.docker.com/compose/install/)

## Installation
1. Clone the repository:
    ```bash
    git clone https://github.com/ecvdbdx1617/Odezenne.git
    ``` 
2. Install the View.js and Lumen dependencies:
    ```bash
    cd Odezenne/scripts
    ./installDevelopment.sh
    ```
   _You will need to install [Cygwin](https://www.cygwin.com/) on windows to execute .sh scripts_
3. Install locally generated certificates to enable HTTPS for Wordpress
   ```bash
    cd ..
   ./scripts/generateCertificates.sh
   ```

   Then complete with the following entries.

   For the first time:
   ```
   Country Name (2 letter code) [AU]:FR
   State or Province Name (full name) [Some-State]:Gironde
   Locality Name (eg, city) []:Bordeaux
   Organization Name (eg, company) [Internet Widgits Pty Ltd]:Odezenne
   Organizational Unit Name (eg, section) []:
   Common Name (e.g. server FQDN or YOUR name) []:wordpress.o2n
   Email Address []:o2n@test.fr
   ```

   For the second time:
   ```
   Country Name (2 letter code) [AU]:FR
   State or Province Name (full name) [Some-State]:Gironde
   Locality Name (eg, city) []:Bordeaux
   Organization Name (eg, company) [Internet Widgits Pty Ltd]:Odezenne
   Organizational Unit Name (eg, section) []:
   Common Name (e.g. server FQDN or YOUR name) []:lumen.o2n
   Email Address []:o2n@test.fr
   ```
4. Create a `.env` file at the root of the project with the different ENV variables for the project. Here is an example of environment variables if using the development WP DB dump
   ```
   ENV=development

   API_HOST=https://lumen.o2n

   WOOCOMMERCE_CONSUMER_KEY=ck_3f882288b4d50fe35759a14619c6f643c421822a
   WOOCOMMERCE_CONSUMER_SECRET=cs_045193a1d84bbbdd8dae7ab9328d49b3081f4d3c
   PAYPAL_CLIENT_ID=AY4uJnG0aQ8UQ_7CGFg6RqWlJqQGEHDFp8MCsmh0WCao_hqZPC5nMGAXlXiMj9-eKIBR8wpLEL1JlhUu
   PAYPAL_CLIENT_SECRET=ENzIaOv5S1L7yE41m2vWOiowiVgoaOuqEEkDBtoNJIyYewxJXShBzm4zDmiMqtercOLpInxJIg71djj3
   ```
5. Build and launch the docker containers:
    ```bash
    docker-compose up
    ```  
6. Setup the Lumen database:  
    ```bash
    ./scripts/setupLumenDb.sh
    ``` 
7. Point the container's IP address to the right hosts by adding these three lines to the `/etc/hosts` file:
    ```bash
    127.0.0.1       lumen.o2n
    127.0.0.1       wordpress.o2n
    127.0.0.1       client.o2n
    ```
8. You can now access the following urls:
    * **lumen.o2n** for the Lumen API
    * **wordpress.o2n** for Wordpress
    * **client.o2n:8081** for the Vue.js client
    
## Front-end development

### Testing
The Vue.js project uses **unit** and **e2e** testing, using [Karma](https://karma-runner.github.io/1.0/index.html) and [Nightwatch](http://nightwatchjs.org/). These tests need to be placed in the `client/test` folder.

To execute the tests, you have these three commands available:
* **To run the unit tests**
    ```bash
    docker exec -it o2n_client npm run unit
    ```
* **To run the e2e tests**
    ```bash
    docker exec -it o2n_client npm run e2e
    ```
* **To run all the tests**
    ```bash
    docker exec -it o2n_client npm run test
    ```
    
### Linting
The Vue.js project follows the [AirBnB](https://github.com/airbnb/javascript) syntax rules using the [ESLint](http://eslint.org/) plugin.

To execute the linter, you can use this command:
```bash
docker exec -it o2n_client npm run lint
```

### Adding dependencies
To add a dependency to the Vue.js project, you have two options:
* Add your dependency to the `package.json` file and execute this command:
```bash
docker exec -it o2n_client npm install
```
* Install the dependency directly using the command line:
```bash
docker exec -it o2n_client npm install {package_name} {--save || --save-dev}
```

## Back-end development

### Importing / Exporting the Wordpress database
The database dump file is located in `config/wp_dump.sql`. To import this file, execute the following script:
```bash
./scripts/importWordpressDb.sh
```
_If you choose to import the existing dump file, the admin username and password are both *admin*_

To export the latest version of the database, execute the following script:
```bash
./scripts/exportWordpressDb.sh
```

To empty the database, execute the following script:
```bash
./scripts/emptyWordpressDb.sh
```

### Initializing the Lumen database
To initialize the database (install & migrate), execute the following script:
```bash
./script/setupLumenDb.sh
```

### Seeding the Lumen database
You can add data to the Lumen database using the seed file located in `api/lumen/database/seeds/DatabaseSeeder.php`. 
Then, to seed the data to the database, execute the following command:
```bash
docker exec -it o2n_lumen php artisan db:seed
```

### Rebuilding the Lumen database
To rebuild the database (drop, recreate, migrate, seed), execute the following script:
```bash
./script/emptyLumenDb.sh
```
