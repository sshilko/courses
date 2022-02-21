<?php

namespace MessageContext\InfrastructureBundle\Tests\Service\Channel;

use MessageContext\Domain\ValueObjects\ChannelAuthorization;
use MessageContext\Domain\ValueObjects\ChannelId;
use MessageContext\Domain\ValueObjects\PublisherId;
use MessageContext\InfrastructureBundle\RequestHandler\Response;
use MessageContext\InfrastructureBundle\Service\ChannelAuthorization\ChannelAuthorizationTranslator;
use MessageContext\InfrastructureBundle\Tests\Resources\MockResponsesLocator;

class ChannelAuthorizationTranslatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ChannelAuthorizationTranslator */
    private $channelAuthorizationTranslator;

    public function setUp()
    {
        $this->channelAuthorizationTranslator = new ChannelAuthorizationTranslator();
    }

    public function testItTranslateAuthorizedResponse()
    {
        $template = MockResponsesLocator::getResponseTemplate("channel200AuthorizationResponse.json");
        $responseContent = sprintf($template, "3333", "1", "true");

        $response = new Response(200);
        $response->setBody(json_decode($responseContent, true));

        $channelAuthorization = $this->channelAuthorizationTranslator->toChannelAuthorizationFromResponse(
            $response
        );

        $channelAuthorizationExpected = new ChannelAuthorization(
            new PublisherId("3333"),
            new ChannelId("1"),
            true
        );

        $this->assertTrue($channelAuthorizationExpected->sameValueAs($channelAuthorization));
    }

    public function testItTranslateNotAuthorizedResponse()
    {
        $template = MockResponsesLocator::getResponseTemplate("channel200AuthorizationResponse.json");
        $responseContent = sprintf($template, "3333", "1", "false");

        $response = new Response(200);
        $response->setBody(json_decode($responseContent, true));

        $channelAuthorization = $this->channelAuthorizationTranslator->toChannelAuthorizationFromResponse(
            $response
        );

        $channelAuthorizationExpected = new ChannelAuthorization(
            new PublisherId("3333"),
            new ChannelId("1"),
            false
        );

        $this->assertTrue($channelAuthorizationExpected->sameValueAs($channelAuthorization));
    }

    /**
     * @expectedException \MessageContext\Application\Exception\AuthorizationNotFoundException
     */
    public function testItRaiseAuthorizationNotFoundException()
    {
        $response = new Response(404);
        $this->channelAuthorizationTranslator->toChannelAuthorizationFromResponse($response);
    }

    /**
     * @expectedException \MessageContext\InfrastructureBundle\Exception\UnableToProcessResponseFromService
     * @dataProvider getNotAcceptableStatusCodes
     * @param $statusCode
     */
    public function testItRaiseUnableToProcessResponseException($statusCode)
    {
        $response = new Response($statusCode);
        $this->channelAuthorizationTranslator->toChannelAuthorizationFromResponse($response);
    }

    /**
     * @expectedException \MessageContext\InfrastructureBundle\Exception\UnableToProcessResponseFromService
     */
    public function testItRaiseUnableToProcessResponseIfContentIsNotExpected()
    {
        $response = new Response(200);
        $contents = ["publisher_id" => 1, "channel" => 2, "authorization:" => false];

        $response->setBody($contents);

        $this->channelAuthorizationTranslator->toChannelAuthorizationFromResponse($response);
    }

    public function getNotAcceptableStatusCodes()
    {
        return [
            [201], [400], [500], [419], [418],
        ];
    }
}
