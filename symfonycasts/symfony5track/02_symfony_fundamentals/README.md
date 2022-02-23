## You've got the Code for Symfony 5 Fundamentals: Services, Config & Environments. Yeehaw!

Hi there! Inside this code download you'll find the following things:

* A `start/` directory: how the project looked at the *start* of the tutorial

* A `finish/` directory: how the project looked after we did all the cool coding

In each directory, you'll find more details about how to set up the project.
But if you have any questions, just post a comment on the course page and
ask!




```
composer self-update --1
composer install

symfony server:ca:install

yarn install
yarn upgrade

#https://github.com/webpack/webpack/issues/14532#issuecomment-947012063
set NODE_OPTIONS=--openssl-legacy-provider
yarn encore dev --watch

#Enable symfony for this project in PHPStorm

composer require knplabs/knp-markdown-bundle

php bin/console.php config:dump KnpMarkdownBundle

php bin/console.php debug:autowiring
php bin/console.php debug:container

#all possible configs
php bin\console config:dump FrameworkBundle cache

#current configs
php bin\console debug:config FrameworkBundle cache

#prod env caches routes & containers
php bin\console cache:clear


#autowiring explained
https://symfony.com/doc/current/service_container/autowiring.html


# config/services.yaml
services:
    # ...

    # the id is not a class, so it won't be used for autowiring
    app.rot13.transformer:
        class: App\Util\Rot13Transformer
        # ...

    # but this fixes it!
    # the ``app.rot13.transformer`` service will be injected when
    # an ``App\Util\Rot13Transformer`` type-hint is detected
    App\Util\Rot13Transformer: '@app.rot13.transformer'


#container scalar parameters
php bin/console.php debug:container --parameters
php bin/console.php debug:container --parameters --env=prod

#info about app
php bin/console.php about

#access environment variables and params
https://medium.com/@votanlean/symfony-parameters-and-environment-variables-ac916524ab49

bind or parameters or ContainerBagInterface or ContainerInterface

#value in .env file will not override the machine environment variable

Env processors
#https://symfony.com/doc/5.4/configuration/env_var_processors.html

php bin/console debug:container --env-vars
php bin/console debug:container --env-vars foo
php bin/console debug:container --parameters

composer dump-env prod
composer dump-env prod --empty
#https://symfony.com/doc/current/deployment.html

#populate dev secret vault
php bin/console secrets:generate-keys
php bin/console secrets:generate-keys --rotate

php bin/console secret:set SENTRY_DSN --env=dev


php bin\console secret:list --env=dev
php bin\console secret:list --reveal

composer require maker --dev
php bin/console make:

php bin/console make:command - "app:random-spell"
php bin/console app:random-spell
php bin/console app:random-spell --help
php bin/console app:random-spell andrew
php bin/console app:random-spell andrew --yell

php bin/console make:twig-extension - "MarkdownExtension"

```


