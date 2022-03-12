## You've got the Code for API Platform Part 3: Custom Resources. Yeehaw!

Hi there! Inside this code download you'll find the following things:

* A `start/` directory: how the project looked at the *start* of the tutorial

* A `finish/` directory: how the project looked after we did all the cool coding

In each directory, you'll find more details about how to set up the project.
But if you have any questions, just post a comment on the course page and
ask!
```

copy docker-compose
update config/packages/doctrine url to test db 

composer install
change composer requirements to 5.*
composer update

yarn install

set NODE_OPTIONS=--openssl-legacy-provider
yarn encore dev --watch

In part 1, 
we got everything we needed for a pretty sweet API. 
We talked about JSON-LD and OpenAPI, 
* operations and config, 
* serialization groups, 
* validation, 
* relations, 
* IRIs, 
* filtering and more.

In part 2, we talked about security, 
logging in, 
adding authorization checks to operations,
making it so that certain fields can be read or
written only by specific users and some pretty serious
work related to custom normalizers for even more control
over exactly which fields each user sees.

So what's in part 3?
It's time to take customizations to the next level,
like making it possible to publish an item and run code when 
that happens... kind of like a custom "publish" operation... 
but with a RESTful twist. We'll also add complex 
security rules around who can publish an item under different conditions.
 
Then we'll do everything custom: 
add completely custom fields, 
completely custom API resources that aren't backed by Doctrine,
custom filters and we'll even dive deep into API Platform's input 
and output DTO system.

DB reset with foundry bundle and https://github.com/dmaicher/doctrine-test-bundle

 *              "security"="is_granted('EDIT', object)",
 has also property previous_object
 
 
 DataProvider for API-Platform, default one, need to decarate, implement
 
 ContextAwareCollectionDataProviderInterface, <<---- for collection
  
 RestrictedDataProviderInterface, 
 
 DenormalizedIdentifiersAwareItemDataProviderInterface <---- for item

https://api-platform.com/docs/core/serialization/

? CLIENT-PROCESS -> DESERIALIZATION -> DATA_PERSISTER -> SERVER
? SERVER-PROCESS -> DATA_PROVIDER -> SERIALIZATION => CLIENT

To mutate the application states during POST, PUT, PATCH or DELETE operations, 
API Platform uses classes called data persisters. 
Data persisters receive an instance of the class marked as an API resource.
This instance contains data submitted by the client during the deserialization process.

CUSTOM FIELD SOLUTIONS
---------------------

1. Add a non-persisted field to entity (DATA_PERSISTERS, DATA_PROVIDERS), 
     Pure PlatformAPI solution 
   - if most fields come from db/entity, an okay option

2. Create a custom API resource class thats not an entity

3. Create an output DTO


https://api-platform.com/docs/core/events/
RequestEvent ->getRequest()->attributes->get('data');

Event system is not used in Api-Platform GraphQL support

custom resource


/**
 *
 * @ApiResource(
 *     itemOperations={
 *         "get"={
 *             "method"="GET",
 *             "controller"=NotFoundAction::class,
 *             "read"=false,
 *             "output"=false,
 *         },
 *     },
 *     collectionOperations={"get"}
 * )
 */
class DailyStats
{
    /**
     * @ApiProperty(identifier=true)
     */
    public \DateTimeImmutable $date;

    public int $totalVisitors;

    public array $mostPopularListings;

    public function getDate(): string
    {
        return $this->date->format('Y-m-d');
    }

}

@ApiProperty(readableLink=true) --- force not to expand IRI, in collection
@ApiProperty(readableLink=false) --- force expand collection in api response

use ApiPlatform\Core\DataProvider\Pagination;
        list($page, $offset, $limit) = $this->pagination->getPagination($resourceClass, $operationName);

 Default built-in filters, only one-at-a-time supported

 Custom filters supported
 * DoctrineORM
 * Elasticsearch
 * completely custom resource
 
 Custom filters support is !QUESTIONABLE! across
 openapi  / swagger / jsonld / graphql
 with some options supported and some not
 documentation somewhere works somewhere not

BadReqyestHttoException 400 anytime

@ApiFilter annotation makes api-platform
 register a service in container, so autowiring is available.
 mayb require overdiding __constructor
 
 using output Dto will transform the original entity tclass to output class
 THEN output class is serialized
   
   
DTO: can have different DTO's on different operations
   
composer require symfony/debug-bundle 
 
```

