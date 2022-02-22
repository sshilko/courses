https://symfony.com/doc/current/setup.html

https://symfony.com/doc/5.4/setup.html

```
symfony new cauldron_overflow --version=lts
symfony check:req

php -S 127.0.0.1:8000 -t public/
symfony server:ca:install
symfony server:start
symfony serve

http://localhost:8000/

```

https://symfony.com/doc/current/service_container.html
```
#almost full list of symfony service objects
php bin/console debug:autowiring
php bin/console debug:autowiring log
```

https://symfonycasts.com/tracks/symfony

https://symfonycasts.com/screencast/symfony

https://symfonycasts.com/tracks/symfony6

[Symfony 4: Best Practices Fabien Potencier April 07, 2017](http://fabien.potencier.org/symfony4-best-practices.html)

```
#route annotations & param converters
#sensio/framework-extra-bundle
composer require annotations

#route annotations via `composer require doctrine/annotations`

#sensiolabs/security-checker
composer require sec-checker --no-scripts

#only add to dev section of composer (with --dev)
composer require profiler --dev

composer require debug
php bin\console server:dump

composer require symfony/asset
php bin/console debug:router

#https://symfony.com/doc/5.4/routing.html
php bin/console router:match /comments/10/vote/up --method=POST

#install symfony/webpack-encore-bundle (requires node nvm yarn)
composer require encore

#install node dependencies into node_modules vendor dir
yarn install

#encore dev --watch
yarn watch 

yarn add jquery --dev
yarn add bootstrap --dev

```


`symfony/flex` adds [aliases/recipe](https://github.com/symfony/recipes/tree/master/sensiolabs/security-checker) to composer, 
i.e. [sensiolabs/security-checker](https://packagist.org/packages/sensiolabs/security-checker)

https://symfony.com/blog/symfony-flex-is-going-serverless
https://symfony.com/blog/fast-smart-flex-recipe-upgrades-with-recipes-update
https://github.com/symfony/recipes


Symfony introduced its [Demo application](https://easycorp.github.io/blog//posts/a-new-easyadmin-demo-application) in 2015 as a learning resource to showcase the main features of the Symfony project. We’ve been maintaining it since then and today it’s still a great resource to learn Symfony, to prepare some quick proof of concept and to benchmark new features.

The "Symfony Demo Application" is a reference application 
created to show how to develop applications
following the [Symfony Best Practices](https://symfony.com/doc/current/best_practices.html).
[Symfony DEMO application](https://github.com/symfony/demo)

[Symfony Bundles](https://symfony.com/bundles)

Symfony [EASY bundles](https://github.com/EasyCorp)
* [EasyAdmin](https://easycorp.github.io/blog/)

 



