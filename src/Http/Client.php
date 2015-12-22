<?php
namespace Ktcrain\VirtualIncentives\Http;

use Ktcrain\VirtualIncentives\Client as ViClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Ktcrain\VirtualIncentives\Http\Exception\RequestException as ViRequestException;

class Client
{
    /**
     * Virtual Incentives Client
     *
     * @var ViClient
     */
    private $viClient;

    /**
     * Guzzle Client
     *
     * @var GuzzleClient
     */
    private $guzzleClient;

    /**
     * Constructor
     *
     * @param ViClient $vi_client ViClient Client
     */
    public function __construct(ViClient $vi_client)
    {
        $this->viClient = $vi_client;

        if($this->viClient->getConfig('sandbox')) {
                $base_url = 'https://rest.virtualincentives.com/v3/json/';
        }
        else {
                $base_url = 'https://rest.virtualincentives.com/v3/json/';
        }
        
        $this->guzzleClient = new GuzzleClient([
            'base_url' => $base_url,
            'defaults' =>  [
                'verify' => false,
            ],
        ]);
    }

    /**
     * Create Request
     *
     * @param string $method  Method
     * @param string $url     URL
     * @param array  $headers Headers
     * @param string $body    Body
     * @param array  $options Options
     *
     * @return mixed Request
     */
    public function createRequest($method, $url, array $headers = [], $body = NULL, array $options = [])
    {
        $arguments = [$method, $url];

        if (!empty($options)) {
            array_push($arguments, $options);
        }

        $request = call_user_func_array([$this->guzzleClient, 'createRequest'], $arguments);

        foreach ($headers as $key => $value) {
            $request->setHeader($key, $value);
        }

        if (!is_null($body)) {
            $request->setBody(Stream::factory($body));
        }

        return $request;
    }

    /**
     * Request
     *
     * @param string $method  Method
     * @param string $url     URL
     * @param array  $headers Headers
     * @param string $body    Body
     * @param array  $options Options
     *
     * @return mixed Response
     */
    public function request($method, $url, array $headers = [], $body = NULL, array $options = [])
    {
        $request = $this->createRequest($method, $url, $headers, $body, $options);

        return $this->send($request);
    }

    /**
     * Send
     *
     * @param mixed $request Request
     *
     * @return mixed Response
     */
    public function send($request)
    {
        try {
            return $this->guzzleClient->send($request);
        } catch (GuzzleRequestException $exception) {
            if ($exception->hasResponse()) {
                return $exception->getResponse();
            } else {
                throw new ViRequestException(sprintf("There was a problem making the request"));
            }
        }
    }

}
