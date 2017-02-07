<?php namespace Justincdotme\OpenCharge\Interfaces;

interface HttpClientInterface
{
    /**
     * Send an GET request to a remote resource.
     * @param $endpoint
     * @param array $params
     */
    public function get( $endpoint, array $params);
}