<?php namespace Justincdotme\OpenCharge;


use Exception;
use GuzzleHttp\Client;
use Justincdotme\OpenCharge\Interfaces\HttpClientInterface;

/**
 * Class HttpClientAdapter
 * @package Justincdotme\OpenCharge
 */
class HttpClientAdapter implements HttpClientInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * HttpClientAdapter constructor.
     * @param Client $client
     */
    public function __construct( Client $client )
    {
        $this->client = $client;
    }

    /**
     * @param $endpoint
     * @param array $params
     * @return \Psr\Http\Message\StreamInterface|string
     */
    public function get( $endpoint, array $params)
    {
        try {
            $response = $this->client->request('GET', $endpoint, ['query' => $params])->getBody();
        } catch (Exception $e) {
            $response = $e->getMessage();
        }
        return $response;
    }
}