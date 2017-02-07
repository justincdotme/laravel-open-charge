<?php namespace Justincdotme\OpenCharge\Facades;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Facade;

class OpenCharge extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'openCharge';
    }
}