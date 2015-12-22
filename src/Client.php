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
            // $key => [array $possibilities, $default],
            'sandbox' => [[true, false], false],
        ] as $key => $rules) {
            $this->setConfig($key, (array_key_exists($key, $config) && in_array($config[$key], $rules[0])) ? $config[$key] : $rules[1]);
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
     * Send
     *
     * @param ServiceInterface $service Service
     *
     * @return mixed Data
     */
    public function send(ServiceInterface $service)
    {
        $service->prepare();

        $method = 'POST';

        $uri = $service->getEndpoint();

        $content_type = $service->getContentType();

        $body = $service->getBody();

        $requestBody = $body;
        echo $requestBody . "\n\n";
        if (isset($_GET['debug'])) {
            echo $requestBody . "\n\n";
        }

        $request = $this->getHttpClient()->createRequest($method, $uri, [
            'Content-Type' => $content_type,
        ], $body);

        $response = $this->getHttpClient()->send($request);

        var_dump($response);die;

        $class = get_class($body);

        $body = new $class;

        $body->setDataFromString($response->getBody(true));

        /*
        if ($body->getTransactionStatus() != 'APPROVED') {
            $transaction_items = $body->getTransactionItems();

            foreach ($transaction_items as $transaction_item) {
                if ($transaction_item['Status'] == 'ERROR') {
                    #throw new RuntimeException(sprintf("%s", $transaction_item['ErrorDescription'] . "\n\n request body \n " . $requestBody . "\n\n response body \n" . $response->getBody(true)));
                    throw new RuntimeException(sprintf("%s", $transaction_item['ErrorDescription']));
                }
            }

            throw new RuntimeException(sprintf("There was a problem making the request"));
        }

        return $body->getTransactionItems();
        */

    }

}
