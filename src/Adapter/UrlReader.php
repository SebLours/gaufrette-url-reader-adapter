<?php

namespace Gaufrette\UrlReader\Adapter;

use Gaufrette\Adapter;
use Gaufrette\UrlReader\UrlGenerator\UrlGeneratorInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

/**
 * Class UrlReader.
 */
class UrlReader implements Adapter
{
    /** @var ClientInterface */
    protected $client;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    /**
     * @param ClientInterface            $client
     * @param UrlGeneratorInterface|null $urlGenerator
     */
    public function __construct(ClientInterface $client, UrlGeneratorInterface $urlGenerator = null)
    {
        $this->client = $client;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritdoc
     */
    public function read($key)
    {
        $url = $this->urlGenerator ? $this->urlGenerator->generateUrl($key) : $key;

        try {
            $response = $this->client->request('GET', $url);
        } catch (ClientException $exception) {
            return false;
        }

        return $response->getBody()->getContents();
    }

    /**
     * @inheritdoc
     */
    public function exists($key)
    {
        $url = $this->urlGenerator ? $this->urlGenerator->generateUrl($key) : $key;

        try {
            $response = $this->client->request('HEAD', $url);
        } catch (ClientException $exception) {
            return false;
        }

        return $response->getStatusCode() === 200;
    }

    /**
     * @inheritdoc
     */
    public function write($key, $content)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function keys()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function mtime($key)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function delete($key)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function rename($sourceKey, $targetKey)
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function isDirectory($key)
    {
        return false;
    }
}
