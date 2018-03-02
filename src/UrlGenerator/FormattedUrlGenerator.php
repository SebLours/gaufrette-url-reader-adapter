<?php

namespace Gaufrette\UrlReader\UrlGenerator;

/**
 * Class FormattedUrlGenerator.
 */
class FormattedUrlGenerator implements UrlGeneratorInterface
{
    /** @var string */
    protected $format;

    /**
     * @param string $format
     */
    public function __construct($format)
    {
        $this->format = $format;
    }

    /**
     * @inheritdoc
     */
    public function generateUrl($key)
    {
        return sprintf($this->format, $key);
    }
}
