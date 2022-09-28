# Assignment
## Summary
This application contains a worker for consuming push notifications jobs.

## Features Overview
* Application level logs (For every single API)
* Increased code coverage by writing different unit and feature tests
* Powerful error handling

## Installation guide
Follow these steps to simply run the project.


### pre requirement

you have to set up rabbit mq on localhost and port 5672
for example with docker image . you have to first install docker in you local machine and then :
```angular2html
docker run -d  -p 4369:4369 -p 5672:5672 -p 15672:15672 -p 25672:25672 --name some-rabbit rabbitmq
```


### Environment variables
There is a `.env.example` file in the project's root directory containing OS level environment variables that are used for deploying the whole application.
Every single variable inside the file has a default value, so you do not need to change them; But you can also override your own variables. First copy the example file to the `.env` file:
```bash
cd /path-to-project
cp .env.example .env
composer install
composer update
php artisan queue:consume
```


## Features descriptions

### Logs

#### Application level logs
Under `storage/logs` directory, you can find detailed logs of API calls.

### Tests
There are different types of testing methods which you can find under `tests` directory. Tests are divided into the following groups:
* feature
* unit

To run tests, in the terminal use the following commands:
```bash
./vendor/bin/phpunit
```


## Author
saeed rasooli [Linkedin](https://www.linkedin.com/in/saeed-rasooli)

