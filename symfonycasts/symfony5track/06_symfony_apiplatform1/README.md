## You've got the Code for API Platform: Serious RESTful APIs. Yeehaw!

Hi there! Inside this code download you'll find the following things:

* A `start/` directory: how the project looked at the *start* of the tutorial

* A `finish/` directory: how the project looked after we did all the cool coding

In each directory, you'll find more details about how to set up the project.
But if you have any questions, just post a comment on the course page and
ask!


```

#update composer.json to symfony 4.4.* 

    "extra": {
        "symfony": {
            "allow-contrib": false,
            "require": "4.2.*|4.3.*|4.4.*"
        }
    },
    

composer require --dev symfony/maker-bundle
composer require doctrine/annotations 
composer require api 

#update docker compose to port 5555 and create .env.local to override system/shared-envs
#.env.local
DATABASE_URL="postgresql://symfony:ChangeMe@0.0.0.0:5555/api?serverVersion=13&charset=utf8

#check that envs loaded
symfony console debug:container --env-vars

docker-compose up

symfony console doc:mig:list

composer require profiler --dev

composer require nesbot/carbon

    /**
     * How long ago something was added
     *
     * @Groups({"cheeze_listing:read"})
     */
    public function getCreatedAtAgo(): string
    {
        return Carbon::instance($this->getCreatedAt())->diffForHumans();
    }

    /**
     * Just text please
     *
     * @Groups({"cheeze_listing:write", "user:write"})
     * @SerializedName("description")
     */
    public function setTextDescription(string $description): self
    {
        $this->description = nl2br($description);

        return $this;
    }

    

```