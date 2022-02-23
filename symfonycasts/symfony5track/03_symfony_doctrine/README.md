## You've got the Code for Doctrine, Symfony & the Database. Yeehaw!

Hi there! Inside this code download you'll find the following things:

* A `start/` directory: how the project looked at the *start* of the tutorial

* A `finish/` directory: how the project looked after we did all the cool coding

In each directory, you'll find more details about how to set up the project.
But if you have any questions, just post a comment on the course page and
ask!

```
yarn install
rm composer.lock

#artificially restrict packages to php 7.4 version to freeze symfony < 5.4

composer config platform.php 7.4
composer config prefer-stable true
rm composer.lock; cd vendor && rm * -rf

composer install
composer update "symfony/*" --with-dependencies

set NODE_OPTIONS=--openssl-legacy-provider
yarn encore dev --watch
symfony serve


#symfony/orm-pack
composer require orm

#enable symfony for this project, change public directory to "public" (not "web")

```