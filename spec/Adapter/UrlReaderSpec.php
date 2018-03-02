<?php

namespace spec\Gaufrette\UrlReader\Adapter;

use Gaufrette\UrlReader\Adapter\UrlReader;
use Gaufrette\UrlReader\UrlGenerator\UrlGeneratorInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class UrlReaderSpec extends ObjectBehavior
{
    function let(
        ClientInterface $client,
        UrlGeneratorInterface $urlGenerator,
        ResponseInterface $response,
        StreamInterface $responseBody
    ) {
        $this->beConstructedWith($client);

        $response->getBody()->willReturn($responseBody);

    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UrlReader::class);
    }

    function it_is_a_read_only_adapter()
    {
        $this->write(Argument::any(), Argument::any())->shouldBe(false);
        $this->keys()->shouldBe(false);
        $this->mtime(Argument::any())->shouldBe(false);
        $this->delete(Argument::any())->shouldBe(false);
        $this->rename(Argument::any(), Argument::any())->shouldBe(false);
        $this->isDirectory(Argument::any())->shouldBe(false);
    }

    function it_reads_a_resource_without_formatting_the_url_if_no_url_generator_is_provided($client, $response, $responseBody)
    {
        $client->request('GET', 'foo')->shouldBeCalled()->willReturn($response);

        $responseBody->getContents()->shouldBeCalled()->willReturn('bar');

        $this->read('foo')->shouldBe('bar');
    }

    function it_reads_a_resource_from_a_formatted_url_if_a_url_generator_is_provided($client, $urlGenerator, $response, $responseBody)
    {
        $this->beConstructedWith($client, $urlGenerator);

        $urlGenerator->generateUrl('foo')->shouldBeCalled()->willReturn('prefix/foo/suffix');

        $client->request('GET', 'prefix/foo/suffix')->shouldBeCalled()->willReturn($response);

        $responseBody->getContents()->shouldBeCalled()->willReturn('bar');

        $this->read('foo')->shouldBe('bar');
    }

    function it_returns_false_while_reading_if_the_resource_is_not_found($client)
    {
        $client->request('GET', 'foo')->shouldBeCalled()->willThrow(ClientException::class);

        $this->read('foo')->shouldBe(false);
    }

    function it_checks_the_resource_exists_without_formatting_the_url_if_no_url_generator_is_provided($client, $response)
    {
        $client->request('HEAD', 'foo')->shouldBeCalled()->willReturn($response);

        $response->getStatusCode()->shouldBeCalled()->willReturn(200);

        $this->exists('foo')->shouldBe(true);
    }

    function it_checks_the_resource_exists_from_a_formatted_url_if_a_url_generator_is_provided($client, $urlGenerator, $response)
    {
        $this->beConstructedWith($client, $urlGenerator);

        $urlGenerator->generateUrl('foo')->shouldBeCalled()->willReturn('prefix/foo/suffix');

        $client->request('HEAD', 'prefix/foo/suffix')->shouldBeCalled()->willReturn($response);

        $response->getStatusCode()->shouldBeCalled()->willReturn(200);

        $this->exists('foo')->shouldBe(true);
    }

    function it_returns_false_while_checking_if_the_resource_is_not_found($client)
    {
        $client->request('HEAD', 'foo')->shouldBeCalled()->willThrow(ClientException::class);

        $this->exists('foo')->shouldBe(false);
    }
}
