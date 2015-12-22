<?php
namespace Ktcrain\VirtualIncentives\Service;

use Ktcrain\VirtualIncentives\Client;
use Ktcrain\VirtualIncentives\Service\Body\BodyInterface;
use Rhumsaa\Uuid\Uuid;

abstract class AbstractService implements ServiceInterface
{
    /**
     * Client
     *
     * @var Client
     */
    private $client;

    /**
     * Content Type
     *
     * @var string
     */
    protected $contentType;

    /**
     * Body
     *
     * @var BodyInterface
     */
    protected $body;

    /**
     * Endpoint
     *
     * @var string
     */
    protected $endpoint;

    /**
     * Constructor
     *
     * @param Client $client Client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->setContentType('application/json');
        $this->setBody(new \Ktcrain\VirtualIncentives\Service\Body\JsonBody);
        $this->configure();
    }


    /**
     * Get Endpoint
     *
     * @return string Endpoint
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Get Client
     *
     * @return Client Client
     */
    public function getClient()
    {
        return $this->client;
    }

    public function generateClientId() {
        return (string) Uuid::uuid4();
    }

    /**
     * Set Content Type
     *
     * @param string $content_type Content Type
     *
     * @return ServiceInterface Service
     */
    public function setContentType($content_type)
    {
        $this->contentType = $content_type;

        return $this;
    }

    /**
     * Get Content Type
     *
     * @return string Content Type
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set Body
     *
     * @param BodyInterface $body Body
     *
     * @return ServiceInterface Service
     */
    public function setBody(BodyInterface $body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get Body
     *
     * @return BodyInterface Body
     */
    public function getBody()
    {
        return $this->body;
    }

}
