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

#git windows credentials 
#@see https://github.com/GitCredentialManager/git-credential-manager/blob/main/docs/configuration.md
git config --global credential.credentialStore cache
git config --global credential.cacheOptions "--timeout 86400"

php bin/console make:docker:database

#download docker for windows, enable windows-hyper-v feature-set
#@see https://stackoverflow.com/questions/39684974/docker-for-windows-error-hardware-assisted-virtualization-and-data-execution-p
#CMD: dism.exe /Online /Enable-Feature:Microsoft-Hyper-V /All
#CMD: bcdedit /set hypervisorlaunchtype auto

#add project name for docker compose into /.env file
#composer uses folder name as project prefix, override that (if our folder is different from default)
COMPOSE_PROJECT_NAME=cauldron_overflow

#Download mysql shell for windows if needed
#https://dev.mysql.com/doc/mysql-shell/8.0/en/mysql-shell-install-windows-quick.html
#https://dev.mysql.com/doc/mysql-shell/8.0/en/mysqlsh.html
#CMD: mysqlsh.exe --sql -u root --password=password --host=127.0.0.1 --port=56553
#\quit to quit

#see which envs symfony pre-populated when we use it as http server (symfony serve)
#it detects the docker running and matches the container names (i.e. database) to env vars
symfony var:export --multiline

#change .env DATABASE_URL to use mysql version
php bin/console doctrine:*
php bin/console doctrine:database:create

#use symfony executable to prepopulate envs (same as web server but for console)
#php bin/console == symfony console

#should work
symfony console doctrine:query:sql "select 123"

php bin/console make:entity

symfony console make:migration
symfony console doctrine:migrations:migrate
symfony console doctrine:migrations:list

#change entity, then create migration again
symfony console make:migration
symfony console doctrine:migrations:migrate


```