## You've got the Code for API Platform Part 2: Security. Yeehaw!

Hi there! Inside this code download you'll find the following things:

* A `start/` directory: how the project looked at the *start* of the tutorial

* A `finish/` directory: how the project looked after we did all the cool coding

In each directory, you'll find more details about how to set up the project.
But if you have any questions, just post a comment on the course page and
ask!


```

composer install
composer update

yarn install

#update composer to symfony 4.* in packages and at end
    "extra": {
        "symfony": {
            "allow-contrib": false,
            "require": "4.3.*|4.4.*"
        }
    },

set NODE_OPTIONS=--openssl-legacy-provider

yarn encore dev --watch

create docker-compose with mysql 5.7 and proper values,
docker-compose up

composer require test --dev

#adjust db for test env

symfony console --env=test doctrine:database:create
symfony console --env=test doctrine:schema:create 

#get all defined services and their aliases, i.e. @doctrine and @logger
php bin/console debug:container


php bin/phpunit

#You cannot create the client used in functional tests if the BrowserKit and HttpClient components are not available. Try running "composer require --dev symfony/browser-kit symfony/http-client"
composer require --dev symfony/http-client

symfony console security:encode-password
#foo
#$argon2id$v=19$m=65536,t=4,p=1$wLzAcp6kcqrsYxKFXMYCXg$4o3519pdRmTqUMC7BIr25X4oX3R6/nccZfD21+DGNZI

```