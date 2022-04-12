<?php

class HTTPClient
{
    /**
     * @param string $url
     * @return false|string
     */
    public function get(string $url)
    {
        return file_get_contents($url);
    }
}