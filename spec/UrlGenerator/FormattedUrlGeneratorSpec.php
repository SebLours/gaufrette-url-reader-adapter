<?php

namespace spec\Gaufrette\UrlReader\UrlGenerator;

use Gaufrette\UrlReader\UrlGenerator\FormattedUrlGenerator;
use PhpSpec\ObjectBehavior;

class FormattedUrlGeneratorSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('/format/%s/request');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FormattedUrlGenerator::class);
    }

    function it_generates_an_url_based_on_the_format()
    {
        $this->generateUrl('my-test')->shouldBeLike('/format/my-test/request');
    }
}
