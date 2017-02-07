<?php namespace Justincdotme\OpenCharge\Interfaces;

interface OpenChargeInterface
{
    /**
     * Get a collection of stations.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get();

    /**
     * Get a raw string list of stations.
     *
     * @return string
     */
    public function getRaw();

    /**
     * Latitude reference for distance calculation
     * Default: blank
     *
     * @param int $latitude
     * @return $this
     */
    public function latitude($latitude);

    /**
     * Longitude reference for distance calculation
     * Default: blank
     *
     * @param int $longitude
     * @return $this
     */
    public function longitude($longitude);

    /**
     * Output formats: json, xml, kml
     * JSON format is recommended as highest fidelity
     * Default: json
     *
     * @param string $output
     * @return $this
     */
    public function output($output);

    /**
     * Set to false to get a smaller result set with null items removed.
     * Default: true
     *
     * @param bool $verbose
     * @return $this
     */
    public function verbose($verbose = true);

    /**
     * Set to true to remove reference data objects from output.
     * Just returns IDs for common reference data such as DataProvider etc.
     * Default: false
     *
     * @param bool $compact
     * @return $this
     */
    public function compactData($compact = true);

    /**
     * Set to true to get a property names in camelCase format.
     * Default: false
     *
     * @param bool $camelCase
     * @return $this
     */
    public function camelCase($camelCase = true);

    /**
     * Miles or KM
     * Default: Miles
     *
     * @param string $distanceUnit
     * @return $this
     */
    public function distanceUnit($distanceUnit);

    /**
     * Return results based on specified distance.
     * Requires lattitude() and longitude() methods.
     * Default: blank
     *
     * @param int $distance
     * @return $this
     */
    public function distance($distance);

    /**
     * Specify the name of the JSONP callback (if required), JSON response type only.
     * Default: blank
     *
     * @param string $callback
     * @return $this
     */
    public function callback($callback);

    /**
     * Set to true to also include user comments and media items (photos) per charging location.
     * Default: false
     *
     * @param bool $includeComments
     * @return $this
     */
    public function comments($includeComments = true);

    /**
     * ISO Country Code.
     * Ex: GB, US
     * Default: blank
     *
     * @param string $countryCode
     * @return $this
     */
    public function countryCode($countryCode);

    /**
     * Exact match on array of country ids.
     * Ex: GB, US
     * Default: blank
     *
     * @param array $countryIds
     * @return $this
     */
    public function countryIds(array $countryIds);

    /**
     * Limit on max number of results returned.
     * Default: 100
     *
     * @param int $maxResults
     * @return $this
     */
    public function limit($maxResults);

    /**
     * Exact match on array of status type ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $statusTypeIds
     * @return $this
     */
    public function statusTypes(array $statusTypeIds);

    /**
     * Exact match on array of charge point ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $chargePointIds
     * @return $this
     */
    public function chargePoint(array $chargePointIds);

    /**
     * Set to false to return only non-open licensed data.
     * Set to true to include only Open Data licensed content.
     * Default: blank
     *
     * @param bool $opendata
     * @return $this
     */
    public function openData($opendata);

    /**
     * Exact match on array of data provider ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $dataProviderIds
     * @return $this
     */
    public function dataProviderIds(array $dataProviderIds);

    /**
     * Exact match on array of usage type ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $usageTypeIds
     * @return $this
     */
    public function usageTypes(array $usageTypeIds);

    /**
     * Exact match on array of EVSE operator ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $operatorIds
     * @return $this
     */
    public function operators(array $operatorIds);

    /**
     * Exact match on array of connection type ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $connectionTypeIds
     * @return $this
     */
    public function connectionTypes(array $connectionTypeIds);

    /**
     * Exact match on array of charging level ids.
     * http://api.openchargemap.io/v2/referencedata/
     * Default: blank
     *
     * @param array $chargingLevelIds
     * @return $this
     */
    public function chargingLevels(array $chargingLevelIds);

    /**
     * POIs modified since the given date (UTC)
     * Ex: 2016-09-15T09:30
     * Default: blank
     *
     * @param string $modifiedsince
     * @return $this
     */
    public function modifiedSince($modifiedsince);
}