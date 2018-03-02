<?php

namespace Gaufrette\UrlReader\UrlGenerator;

/**
 * Interface UrlGeneratorInterface.
 */
interface UrlGeneratorInterface
{
    /**
     * @param $key
     *
     * @return string
     */
    public function generateUrl($key);
}
