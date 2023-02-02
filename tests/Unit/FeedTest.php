<?php

namespace UnixDevil\FeedBoat\Tests\Unit;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Mockery;

use UnixDevil\FeedBoat\Clients\FeedClient;
use UnixDevil\FeedBoat\DTO\FeedDTO;

class FeedTest extends \UnixDevil\FeedBoat\Tests\TestCase
{

    /**
     * @throws \JsonException
     * @throws GuzzleException
     */
    public function testGetSentiment()
    {

        $sentiment= $this->getMockBuilder(FeedDTO::class)
            ->getMock();
        //generate a test for the sentiment client
        $mock = $this->getMockBuilder(FeedClient::class)
            ->setConstructorArgs([Mockery::mock(ClientInterface::class)])
            ->getMock();
        $mock->method('find')
            ->with('laravel')
            ->willReturn($sentiment);

        $this->assertSame($sentiment, $mock->find('laravel'));

    }

}
