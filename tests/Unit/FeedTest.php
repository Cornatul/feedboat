<?php

namespace UnixDevil\FeedBoat\Tests\Unit;

use Cornatul\Feeds\Clients\FeedlyClient;
use Cornatul\Feeds\DTO\FeedDto;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Mockery;


class FeedTest extends \UnixDevil\FeedBoat\Tests\TestCase
{

    /**
     * @throws \JsonException
     * @throws GuzzleException
     */
    public function testGetSentiment()
    {

        $dto= $this->getMockBuilder(FeedDto::class)
            ->getMock();
        //generate a test for the sentiment client
        $mock = $this->getMockBuilder(FeedlyClient::class)
            ->setConstructorArgs([Mockery::mock(ClientInterface::class)])
            ->getMock();
        $mock->method('find')
            ->with('laravel')
            ->willReturn($dto);

        $this->assertSame($dto, $mock->find('laravel'));

    }

}
