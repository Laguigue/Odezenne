# Odezenne project

## Includes
- [Wordpress REST API](http://v2.wp-api.org/) with MariaDB database
- [Lumen](https://lumen.laravel.com/) API with MariaDB database
- [Vue.js](https://vuejs.org/) client

## Dependencies
- [Docker](https://docs.docker.com/engine/installation/) & [Docker-compose](https://docs.docker.com/compose/install/)

## Installation
1. Clone the repository
    ```
    git clone https://github.com/ecvdbdx1617/Odezenne.git
    ``` 
2. Install the View.js and Lumen dependencies
    ```
    ./install.sh
    ```
3. Build and launch the docker containers
    ```
    docker-compose up
    ```     
4. Point the container's IP address to the right hosts by adding these three lines to the `/etc/hosts` file
    ```
    127.0.0.1       lumen.o2n
    127.0.0.1       wordpress.o2n
    127.0.0.1       client.o2n`
    ```
5. You can now access the following urls:
    * **lumen.o2n:8080** for the Lumen API
    * **wordpress.o2n:8080** for Wordpress
    * **client.o2n:8081** for the Vue.js client
    
## Front-end development

### Testing
The Vue.js project uses **unit** and **e2e** testing, using [Karma](https://karma-runner.github.io/1.0/index.html) and [Nightwatch](http://nightwatchjs.org/). These tests need to be placed in the `client/test` folder.

To execute the tests, you have these three commands available
* **To run the unit tests**
    ```
    docker exec -it o2n_client npm run unit
    ```
* **To run the e2e tests**
    ```
    docker exec -it o2n_client npm run e2e
    ```
* **To run all the tests**
    ```
    docker exec -it o2n_client npm run test
    ```
    
### Linting
The Vue.js project follows the [AirBnB](https://github.com/airbnb/javascript) syntax rules using the [ESLint](http://eslint.org/) plugin.

To execute the linter, you can use this command
```
docker exec -it o2n_client npm run lint
```

### Adding dependencies
To add a dependency to the Vue.js project, you have two options:
* Add your dependency to the `package.json` file and execute this command
```
docker exec -it o2n_client npm install
```
* Install the dependency directly using the command line
```
docker exec -it o2n_client npm install {package_name} {--save || --save-dev}
```
