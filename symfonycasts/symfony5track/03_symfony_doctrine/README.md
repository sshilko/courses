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

#need to update to symfony 5.3 to continue with time bundle in twig
#go to composer.json and replace "5.1." with "5.3." bacause time-bundle has some package conflicts etc.
composer update "symfony/*" --with-dependencies

#now install bundle (provides twig "|ago" filter)
composer require knplabs/knp-time-bundle

#things can have as controller arguments
* An argument whose "name" matches a route {wildcard}
@Route("/article{slug}")
public function example($slug)

Autowire a service via its type-hint
@Route("/article{slug}")
public function example(LoggerInterface $logger)

Autowire an entity class to automatically query for that entity
@Route("/article{slug}")
public function example(ArticleEntity $article)

Autowire a Request class Symfony\Component\HttpFoundation\Request that contains request data
@Route("/article{slug}")
public function example(Request $request)


and other usual things like
> repositories
> binded/params global or specified in config/services.yml


#only needed to add new object, or make entityManager aware of entity
#if objects comes FROM entityManager, no need to do persist (optional)
$entityManager->persist($entity)

symfony console debug:twig

#Doctrine fixtures
composer require orm-fixtures --dev

symfony console doctrine:fixtures:load


#Fixtures factory
https://github.com/zenstruck/foundry
https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html

composer require zenstruck/foundry --dev

# To use the make:* commands from this bundle, ensure Symfony MakerBundle is installed.
# via composer require maker --dev

symfony console make:factory

#https://github.com/stof/StofDoctrineExtensionsBundle
#https://symfony.com/bundles/StofDoctrineExtensionsBundle/current/index.html

composer require stof/doctrine-extensions-bundle

```