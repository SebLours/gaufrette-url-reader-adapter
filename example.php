<?php

require ('vendor/autoload.php');

use Gaufrette\Filesystem;
use Gaufrette\UrlReader\Adapter\UrlReader;
use Gaufrette\UrlReader\UrlGenerator\FormattedUrlGenerator;
use GuzzleHttp\Client;

$youtubeUrlGenerator = new FormattedUrlGenerator('/vi/%s/maxresdefault.jpg');
$youtubeClient = new Client(['base_uri' => 'https://img.youtube.com']);

$youtubeFS = new Filesystem(new UrlReader($youtubeClient, $youtubeUrlGenerator));

$youtubeFS->read('m2p55BmwmJM');