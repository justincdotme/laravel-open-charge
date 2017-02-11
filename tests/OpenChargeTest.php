<?php
use Justincdotme\OpenCharge\OpenCharge;
use \PHPUnit\Framework\TestCase;

class OpenChargeTest extends TestCase
{

    protected $client;
    protected $config;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->config = $this->getMockBuilder(Illuminate\Contracts\Config\Repository::class)
            ->getMock();
        $this->client = $this->getMockBuilder(Justincdotme\OpenCharge\Interfaces\HttpClientInterface::class)
            ->setMethods(['get'])
            ->getMock();
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @test
     */
    public function it_returns_collection_for_get_method()
    {
        $openCharge = new OpenCharge($this->client, $this->config);
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $openCharge->get());
    }

    /**
     * @test
     */
    public function it_returns_string_for_getRaw_method()
    {
        $openCharge = new OpenCharge($this->client, $this->config);
        $this->assertInternalType('string', $openCharge->getRaw());
    }

    /**
     * @test
     */
    public function it_passed_correct_filters_from_convenience_methods_to_http_client_collaborator()
    {
        $this->client
            ->expects($this->once())
            ->method('get')
            ->with(
                $this->anything(),
                $this->callback(function ($appliedFilters) {
                    $expectedFilters = [
                        'distance',
                        'maxresults',
                        'output',
                        'verbose',
                    ];
                    foreach ($expectedFilters as $filter) {
                        if (!array_key_exists($filter, $appliedFilters)) {
                            return false;
                        }
                    }
                    return true;
                })
            );
        $openCharge = new OpenCharge($this->client, $this->config);
        $openCharge->distance(4)
            ->limit(4)
            ->output('xml')
            ->verbose(true)
            ->get();
    }

    /**
     * @test
     */
    public function it_passed_correct_filters_from_filter_method_to_http_client_collaborator()
    {
        $this->client
            ->expects($this->once())
            ->method('get')
            ->with(
                $this->anything(),
                $this->callback(function ($appliedFilters) {
                    $expectedFilters = [
                        'distance',
                        'maxresults',
                        'output',
                        'verbose',
                    ];
                    foreach ($expectedFilters as $filter) {
                        if (!array_key_exists($filter, $appliedFilters)) {
                            return false;
                        }
                    }
                    return true;
                })
            );
        $openCharge = new OpenCharge($this->client, $this->config);
        $openCharge->filters([
                'distance' => 10,
                'maxresults' => 1,
                'output' => 'json',
                'verbose' => true,
            ])->get();
    }
}