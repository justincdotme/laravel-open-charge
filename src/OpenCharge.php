<?php namespace Justincdotme\OpenCharge;

use Illuminate\Contracts\Config\Repository as Config;
use Justincdotme\OpenCharge\Interfaces\HttpClientInterface;
use Justincdotme\OpenCharge\Interfaces\OpenChargeInterface;

/**
 * Class OpenCharge
 * A fluent interface for the Open Charge POI API.
 *
 * POI API Documentation: https://openchargemap.org/site/develop/api
 * API Reference Data: http://api.openchargemap.io/v2/referencedata/
 *
 * @package App\Lib\OpenCharge
 */
class OpenCharge implements OpenChargeInterface
{
    /**
     * Http Client
     *
     * @var Client
     */
    protected $client;

    /**
     * App configuration
     *
     * @var Config
     */
    protected $config;

    /**
     * URL Filter Params
     *
     * @var array
     */
    protected $filters;

    /**
     * OpenCharge constructor.
     *
     * @param HttpClientInterface $client
     * @param Config $config
     */
    public function __construct( HttpClientInterface $client, Config $config )
    {
        $this->config = $config;
        $this->client = $client;
        $this->filters = [];
    }

    /**
     * Get a collection of stations.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return collect( json_decode( $this->getRemoteData() ) );
    }

    /**
     * Get a raw string list of stations.
     *
     * @return string
     */
    public function getRaw()
    {
        return (string)$this->getRemoteData();
    }

    /**
     * Get remote data via the Http Client Adapter.
     * @return mixed
     */
    protected function getRemoteData()
    {
        return $this->client->get( $this->config->get( 'opencharge.baseUrl' ), $this->filters );
    }

    /**
     * Latitude reference for distance calculation
     * Default: blank
     *
     * @param int $latitude
     * @return $this
     */
    public function latitude( $latitude )
    {
        $this->filters['latitude'] = $latitude;
        return $this;
    }

    /**
     * Longitude reference for distance calculation
     * Default: blank
     *
     * @param int $longitude
     * @return $this
     */
    public function longitude( $longitude )
    {
        $this->filters['longitude'] = $longitude;
        return $this;
    }

    /**
     * Output formats: json, xml, kml
     * JSON format is recommended as highest fidelity
     * Default: json
     *
     * @param string $output
     * @return $this
     */
    public function output( $output )
    {
        $this->filters['output'] = $output;
        return $this;
    }

    /**
     * Set to false to get a smaller result set with null items removed.
     * Default: true
     *
     * @param bool $verbose
     * @return $this
     */
    public function verbose( $verbose = true )
    {
        $this->filters['verbose'] = $verbose;
        return $this;
    }

    /**
     * Set to true to remove reference data objects from output.
     * Just returns IDs for common reference data such as DataProvider etc.
     * Default: false
     *
     * @param bool $compact
     * @return $this
     */
    public function compactData( $compact = true )
    {
        $this->filters['compact'] = $compact;
        return $this;
    }

    /**
     * Set to true to get a property names in camelCase format.
     * Default: false
     *
     * @param bool $camelCase
     * @return $this
     */
    public function camelCase( $camelCase = true )
    {
        $this->filters['camelcase'] = $camelCase;
        return $this;
    }

    /**
     * Miles or KM
     * Default: Miles
     *
     * @param string $distanceUnit
     * @return $this
     */
    public function distanceUnit( $distanceUnit )
    {
        $this->filters['distanceunit'] = $distanceUnit;
        return $this;
    }

    /**
     * Return results based on specified distance.
     * Requires lattitude() and longitude() methods.
     * Default: blank
     *
     * @param int $distance
     * @return $this
     */
    public function distance( $distance )
    {
        $this->filters['distance'] = $distance;
        return $this;
    }

    /**
     * Specify the name of the JSONP callback (if required), JSON response type only.
     * Default: blank
     *
     * @param string $callback
     * @return $this
     */
    public function callback( $callback )
    {
        $this->filters['callback'] = $callback;
        return $this;
    }

    /**
     * Set to true to also include user comments and media items (photos) per charging location.
     * Default: false
     *
     * @param bool $includeComments
     * @return $this
     */
    public function comments( $includeComments = true )
    {
        $this->filters['includecomments'] = $includeComments;
        return $this;
    }

    /**
     * ISO Country Code.
     * Ex: GB, US
     * Default: blank
     *
     * @param string $countryCode
     * @return $this
     */
    public function countryCode( $countryCode )
    {
        $this->filters['countrycode'] = $countryCode;
        return $this;
    }

    /**
     * Exact match on array of country ids.
     * Ex: GB, US
     * Default: blank
     *
     * @param array $countryIds
     * @return $this
     */
    public function countryIds( array $countryIds )
    {
        $this->filters['countryid'] = implode( ',', $countryIds );
        return $this;
    }

    /**
     * Limit on max number of results returned.
     * Default: 100
     *
     * @param int $maxResults
     * @return $this
     */
    public function limit( $maxResults )
    {
        $this->filters['maxresults'] = $maxResults;
        return $this;
    }

    /**
     * Exact match on array of status type ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $statusTypeIds
     * @return $this
     */
    public function statusTypes( array $statusTypeIds )
    {
        $this->filters['statustypeid'] = implode( ',', $statusTypeIds );
        return $this;
    }

    /**
     * Exact match on array of charge point ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $chargePointIds
     * @return $this
     */
    public function chargePoint( array $chargePointIds )
    {
        $this->filters['chargepointid'] = implode( ',', $chargePointIds );
        return $this;
    }

    /**
     * Set to false to return only non-open licensed data.
     * Set to true to include only Open Data licensed content.
     * Default: blank
     *
     * @param bool $opendata
     * @return $this
     */
    public function openData( $opendata )
    {
        $this->filters['opendata'] = $opendata;
        return $this;
    }

    /**
     * Exact match on array of data provider ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $dataProviderIds
     * @return $this
     */
    public function dataProviderIds( array $dataProviderIds )
    {
        $this->filters['dataproviderid'] = implode( ',', $dataProviderIds );
        return $this;
    }

    /**
     * Exact match on array of usage type ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $usageTypeIds
     * @return $this
     */
    public function usageTypes( array $usageTypeIds )
    {
        $this->filters['usagetypeid'] = implode( ',', $usageTypeIds );
        return $this;
    }

    /**
     * Exact match on array of EVSE operator ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $operatorIds
     * @return $this
     */
    public function operators( array $operatorIds )
    {
        $this->filters['operatorid'] = implode( ',', $operatorIds );
        return $this;
    }

    /**
     * Exact match on array of connection type ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $connectionTypeIds
     * @return $this
     */
    public function connectionTypes( array $connectionTypeIds )
    {
        $this->filters['connectiontypeid'] = implode( ',', $connectionTypeIds );
        return $this;
    }

    /**
     * Exact match on array of charging level ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $chargingLevelIds
     * @return $this
     */
    public function chargingLevels( array $chargingLevelIds )
    {
        $this->filters['levelid'] = implode( ',', $chargingLevelIds );
        return $this;
    }

    /**
     * POIs modified since the given date (UTC)
     * Ex: 2016-09-15T09:30
     * Default: blank
     *
     * @param string $modifiedsince
     * @return $this
     */
    public function modifiedSince( $modifiedsince )
    {
        $this->filters['modifiedsince'] = $modifiedsince;
        return $this;
    }
}