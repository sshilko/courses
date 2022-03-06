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

#update to symfony 5.4 due to `composer require alice --dev` dependency on 5.4

#Hautelook\AliceBundle\HautelookAliceBundle
composer require "alice:^2.7" --dev

#monolog logger
composer require logger

#api-platform-2.4
1 Deserializes the json and updates the CheeseListing onject
>>>BUG with security/ownership possible in put, use "previous_object" before json is prossed
2. Applies access_control security
3. Executes validation rules

#api-platform-2.5+
1.use "security" option instead of "access_control"
"security" runs before object is updated from POST data.
Advanced: security_post_denormalize to run security after deserialization,
then object variable is updated object


AuthorizationCheckerInterface is same, just exposes isGranted
otherwise can use Security for isGranted

#AuthorizationCheckerInterface $authorizationChecker, Security $security
$this->authorizationChecker->isGranted('ROLE_ADMIN') &&
$this->security->isGranted('ROLE_ADMIN') &&

Used AutoGroupsContextBuilder adds dynamicly groups and adds bunch of pre-made groups
if we follow naming convention like.

But those dynamic groups do not show on documentation by default, they will work, but
documentation will be broken.
To fix that we need Resource Metadata Factory: Dynamic ApiResource Options

tof ix that need to make our own metadata factory, by decorating the default factory

class AutoGroupResourceMetadataFactory implements ResourceMetadataFactoryInterface

@see https://symfonycasts.com/screencast/api-platform-security/resource-metadata-factory#play

this serializer need to be defined in services for Symfony to recognize it
(we decorating api_platform.serializer.context_builder)

    App\Serializer\AutoGroupsContextBuilder:
        decorates: 'api_platform.serializer.context_builder'
        arguments: [ '@App\Serializer\AutoGroupsContextBuilder.inner' ]
        autoconfigure: false

user:write
user:read
user:item:read
user:collection:read
...



/**
 * @ApiResource(
 *     collectionOperations={
 *     "get",
 *     "post" = {"security" = "is_granted('ROLE_USER')"}
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={"groups"={"cheese_listing:read", "cheese_listing:item:get"}},
 *          },
 *          "put" = {
 *              "security" = "is_granted('ALLOW_CHEESELISTING_EDIT', object)",
 *              "security_message" = "Only owner can edit cheese: Simplified can be as is_granted('ROLE_USER') and object.getOwner() == user, but instead lets try voter"
 *          },
 *          "delete" = {"security" = "is_granted('ROLE_ADMIN')"}
 *     },
 *     shortName="cheeses",
 *     normalizationContext={"groups"={"cheese_listing:read"}, "swagger_definition_name"="Read"},
 *     denormalizationContext={"groups"={"cheese_listing:write"}, "swagger_definition_name"="Write"},
 *     attributes={
 *          "pagination_items_per_page"=10,
 *          "formats"={"jsonld", "json", "html", "jsonhal", "csv"={"text/csv"}}
 *     }
 * )
 * @ApiFilter(BooleanFilter::class, properties={"isPublished"})
 * @ApiFilter(SearchFilter::class, properties={
 *     "title": "partial",
 *     "description": "partial",
 *     "owner": "exact",
 *     "owner.username": "partial"
 * })
 * @ApiFilter(RangeFilter::class, properties={"price"})
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass="App\Repository\CheeseListingRepository")
 */
 
 

```