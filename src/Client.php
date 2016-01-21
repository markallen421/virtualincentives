<?php
namespace Ktcrain\VirtualIncentives;

use Ktcrain\VirtualIncentives\Exception\BadMethodCallException;
use Ktcrain\VirtualIncentives\Exception\InvalidArgumentException;
use Ktcrain\VirtualIncentives\Exception\RuntimeException;
use Ktcrain\VirtualIncentives\Http\Client as HttpClient;
use Ktcrain\VirtualIncentives\Service\ServiceInterface;
use Ktcrain\VirtualIncentives\Util\Arr;

class Client
{
    /**
     * Config
     *
     * @var array
     */
    private $config = [];

    /**
     * HTTP Client
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Events
     *
     * @var array
     */
    private $events = [];

    /**
     * Constructor
     *
     * @param array $config Config
     */
    public function __construct(array $config = [])
    {        
        foreach ([
            'sandbox' => [[true, false], false],
        ] as $key => $rules) {
            $this->setConfig($key, (array_key_exists($key, $config) && in_array($config[$key], $rules[0])) ? $config[$key] : $rules[1]);
        }
        foreach($config as $key => $value) {
            $this->setConfig($key, $value);
        }
    }

    /**
     * Method Overloading
     *
     * @param string $name      Name
     * @param array  $arguments Arguments
     *
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        try {
            $name = ucfirst($name);
            return $this->getService($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf("Method `%s` does not exist", $name));
        }
    }

    /**
     * Has Config
     *
     * @param string $key Key
     *
     * @return boolean Whether the key exists or not
     */
    public function hasConfig($key)
    {
        return Arr::has($this->config, $key);
    }

    /**
     * Set Config
     *
     * @param string $key   Key
     * @param mixed  $value Value
     *
     * @return Client Client
     */
    public function setConfig($key, $value)
    {
        Arr::set($this->config, $key, $value);

        return $this;
    }

    /**
     * Get Config
     *
     * @param string $key      Key
     * @param mixed  $fallback Default return value
     *
     * @return mixed Value
     */
    public function getConfig($key, $fallback = null)
    {
        return Arr::get($this->config, $key, $fallback);
    }

    /**
     * Get HTTP Client
     *
     * @return HttpClient HTTP Client
     */
    public function getHttpClient()
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new HttpClient($this);
        }

        return $this->httpClient;
    }

    /**
     * Get Service
     *
     * @param string $service Service
     *
     * @return Service Service
     */
    public function getService($service)
    {
        $class = __NAMESPACE__ . '\\Service\\' . $service . 'Service';

        if (!class_exists($class)) {
            throw new InvalidArgumentException(sprintf("Service `%s` does not exist", $service));
        }

        return new $class($this);
    }

    /**
     * @return string
     */
    public function getAuthString() {
        return base64_encode($this->getConfig('username').':'.$this->getConfig('password'));
    }

    /**
     * Send
     *
     * @param ServiceInterface $service Service
     *
     * @return mixed Data
     */
    public function send(ServiceInterface $service)
    {
        $service->prepare();

        $method = $service->getMethod();

        $uri = $service->getEndpoint();

        $content_type = $service->getContentType();

        $body = $service->getBody();

        $requestBody = $body;
        if (isset($_GET['debug'])) {
            echo $requestBody . "\n\n";
        }

        $request = $this->getHttpClient()->createRequest($method, $uri, [
            'Content-Type' => $content_type,
            'Authorization' => 'Basic '.$this->getAuthString()
        ], $body);

        $response = $this->getHttpClient()->send($request);

        if($response->getStatusCode() !== '200') {
            throw new RuntimeException($response->getStatusCode().' '.$response->getReasonPhrase());
        }

        // Ktcrain\VirtualIncentives\Service\Body\JsonBody
        $class = get_class($body);

        $body = new $class;

        $body->setDataFromString($response->getBody(true));

        $data = $body->getData();

        if (empty($data)) {
            throw new RuntimeException(sprintf("There was a problem making the request"));
        }

        if(isset($data['order']['errors'])) {
            $err = $data['order']['errors'][0];
            // accounts error
            if($err['code'] == '15') {
                $err = $data['order']['accounts'][0]['errors'][0];
            }
            throw new RuntimeException(sprintf("Error code %s (field %s) %s", $err['code'],$err['field'],$err['message']));
        }

        return $body->getData();

    }

}
