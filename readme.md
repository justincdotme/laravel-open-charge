# Laravel Open Charge
 Laravel Open Charge provides a fluent wrapper for the [Open Charge Map POI API](https://openchargemap.org/site/develop/api)
 
 The goal of this project is to enable the developer can more easily focus on their application by creating a layer of abstraction on top of the Open Charge API.

## Installation
######This application requires Laravel 5.* OR Lumen 5.*
### Lumen 5.* Installation
Install the package using Composer

    composer require justincdotme/laravel-open-charge

You can optionally enable Facades by uncommenting the following from bootstrap/app.php

    $app->withFacades();
    
Register the Service Provider by adding the following to bootstrap/app.php
    
    $app->register(Justincdotme\OpenCharge\Providers\OpenChargeServiceProvider::class);
    
    
### Laravel 5.* Installation
Install the package using Composer

    composer install justincdotme/loc
    
Register the Service Provider to the providers array in config/app.php

    'providers' => [
     ...
     Justincdotme\OpenCharge\Providers\OpenChargeServiceProvider::class,
     ...
     ]
    
 Optionally: Publish the config with the following command in Laravel:
 
    php artisan vendor:publish and edit app/config.php
    
## Usage

####Facade
    use Illuminate\Http\Request;
    
    OpenCharge::latitude($request->latitude)
        ->longitude($request->longitude)
        ->distance(10)
        ->compactData()
        ->verbose(false)
        ->limit(4)
        ->get();    
        
####Constructor/Method Injection
    use Illuminate\Http\Request;
    use Justincdotme\OpenCharge\Interfaces\OpenChargeInterface;

    public function foo(OpenChargeInterface $openCharge, Request $request)
    {
        return $openCharge->latitude($request->latitude)
             ->longitude($request->longitude)
             ->distance(10)
             ->compactData()
             ->verbose(false)
             ->limit(4)
             ->get(); 
    }
        
  **Note** 
  
  Please note that the get() method returns a Collection from a JSON string, as such, is not compatible with output types other than JSON.
  Use the OpenCharge::getRaw() method in conjunction with the OpenCharge::output() method if you would like an alternate output format. The getRaw() method returns a string.

  While not required, it is recommended that you supply latitude and longitude. Otherwise, the results may not be tailored to the user's location. 


Additional documentation on the Open Charge Map API is beyond the scope of this readme and can be located at [Open Charge Map POI API](https://openchargemap.org/site/develop/api)
## Available Methods

Get a collection of stations. Must be the final method in the chain.

    OpenCharge::get()


Get a list of stations as a raw string. Must be the final method in the chain.

    OpenCharge::getRaw()


Latitude reference for distance calculation

    OpenCharge::latitude( $latitude )


Longitude reference for distance calculation

    OpenCharge::longitude( $longitude )


Output formats: json, xml, kml 
JSON format is recommended as highest fidelity

    OpenCharge::output( $output )


Set to false to get a smaller result set with null items removed.

    OpenCharge::verbose( $verbose = true )


Set to true to remove reference data objects from output.
Just returns IDs for common reference data such as DataProvider etc.

    OpenCharge::compactData( $compact = true )


Set to true to get a property names in camelCase format.

    OpenCharge::camelCase( $camelCase = true )


Miles or KM

    OpenCharge::distanceUnit( $distanceUnit )


Return results based on specified distance.
Requires lattitude() and longitude() methods.

    OpenCharge::distance( $distance )


Specify the name of the JSONP callback (if required), JSON response type only.

    OpenCharge::callback( $callback )


Set to true to also include user comments and media items (photos) per charging location.

    OpenCharge::comments( $includeComments = true )


ISO Country Code. 
Ex: GB, US

    OpenCharge::countryCode( $countryCode )


Exact match on array of country ids. 
Ex: GB, US

    OpenCharge::countryIds( array $countryIds )


Limit on max number of results returned.

    OpenCharge::limit( $maxResults )


Exact match on array of status type ids.
[Open Charge Map Reference Data](http://api.openchargemap.io/v2/referencedata)

    OpenCharge::statusTypes( array $statusTypeIds )


Exact match on array of charge point ids.
[Open Charge Map Reference Data](http://api.openchargemap.io/v2/referencedata)

    OpenCharge::chargePoint( array $chargePointIds )


Set to false to return only non-open licensed data.
Set to true to include only Open Data licensed content.

    OpenCharge::openData( $opendata )


Exact match on array of data provider ids.
[Open Charge Map Reference Data](http://api.openchargemap.io/v2/referencedata)

    OpenCharge::dataProviderIds( array $dataProviderIds )


Exact match on array of usage type ids.
[Open Charge Map Reference Data](http://api.openchargemap.io/v2/referencedata)

    OpenCharge::usageTypes( array $usageTypeIds )


Exact match on array of EVSE operator ids.
[Open Charge Map Reference Data](http://api.openchargemap.io/v2/referencedata)

    OpenCharge::operators( array $operatorIds )


Exact match on array of connection type ids.

    OpenCharge::connectionTypes( array $connectionTypeIds )


Exact match on array of charging level ids.

    OpenCharge::chargingLevels( array $chargingLevelIds )


POIs modified since the given date (UTC)

    OpenCharge::modifiedSince( $modifiedsince )

## License

 The MIT License (MIT)
 
 Copyright (c) 2017 Justin Christenson
 
 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:
 
 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.
 
 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE.