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

```


