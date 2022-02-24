## You've got the Code for Mastering Doctrine Relations. Yeehaw!

Hi there! Inside this code download you'll find the following things:

* A `start/` directory: how the project looked at the *start* of the tutorial

* A `finish/` directory: how the project looked after we did all the cool coding

In each directory, you'll find more details about how to set up the project.
But if you have any questions, just post a comment on the course page and
ask!

```

composer install

yarn install
set NODE_OPTIONS=--openssl-legacy-provider
yarn encore dev --watch

#fix .env mysql version from 5.7 to 8.0

#add to .env
COMPOSE_PROJECT_NAME=cauldron_overflow 

#add to docker-compose.yaml
            MYSQL_DATABASE: main

docker container prune

docker-compose up

#check port and test connection, i.e. port 49973
mysqlsh.exe --sql -u root --password=password --host=127.0.0.1 --port=49973

#launch symfony server, so it catches up local docker envs

symfony serve

#symfony will pre-create the database from docker-compose, otherwise create one
symfony console doctrine:database:create

#double check that symfony picked up the DB from composer
symfony var:export --multiline

#list and apply migrations
symfony console doctrine:migrations:list
symfony console doctrine:migrations:migrate

#load fixtures
symfony console doctrine:fixtures:load

#check homepage for working server, db etc. all should be as from last course, but symfony5.3.7

Mapping ManyToOne is required, but OneToMany not (optional); Many Answers to One Questions. Foreign key in db in on answers table. Questions table has not FK/etc.

Cant inject service objects into Entity, rather create i.e. Criteria in Repository and use inside entity objec, as static function

Criteria is reusable in DQL builder (inside repository for building where etc.)

composer require twig/string-extra

https://symfony.com/doc/current/components/string.html
symfony string '|u' twig modifier and '|u.truncate'
