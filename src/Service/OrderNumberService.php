<?php
namespace Ktcrain\VirtualIncentives\Service;

class OrderNumberService extends AbstractService
{
    /**
     * Number
     *
     * @var integer
     */
    protected $number;

    /**
     * Endpoint
     *
     * @var string
     */
    protected $endpoint = 'order/{number}';

    /**
     * @var method string
     */
    protected $method = 'GET';

    /**
     * Configure
     *
     * @return void
     */
    public function configure(){}

    /**
     * Prepare
     *
     * @return void
     */
    public function prepare()
    {
        $this->endpoint = str_replace('{number}', $this->number, $this->endpoint);
    }

    /**
     * Set Number
     *
     * @param string $number number
     * @return OrderNumberService Service
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * Get Number
     *
     * @return string number
     */
    public function getNumber()
    {
        return $this->number;
    }

}
