<?php
namespace Ktcrain\VirtualIncentives\Service;

use Ktcrain\VirtualIncentives\Client;
use Ktcrain\VirtualIncentives\Service\Body\BodyInterface;

interface ServiceInterface
{
    /**
     * Constructor
     *
     * @param Client $client Client
     */
    public function __construct(Client $client);

    /**
     * Configure
     *
     * @return void
     */
    public function configure();

    /**
     * Prepare
     *
     * @return void
     */
    public function prepare();

    /**
     * Set Body
     *
     * @param BodyInterface $body Body
     */
    public function setBody(BodyInterface $body);

    /**
     * Get Body
     *
     * @return BodyInterface Body
     */
    public function getBody();

}
