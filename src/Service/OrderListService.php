<?php
namespace Ktcrain\VirtualIncentives\Service;

class OrderListService extends AbstractService
{
    /**
     * Orders
     *
     * @var object
     */
    protected $orders;

    /**
     * Endpoint
     *
     * @var string
     */
    protected $endpoint = 'order/list';

    /**
     * Configure
     *
     * @return void
     */
    public function configure()
    {
        $this->orders = (object) [
            'programid' => null,
        ];
    }

    /**
     * Prepare
     *
     * @return void
     */
    public function prepare()
    {
        $this->getBody()->set('orders', $this->orders);
    }

    /**
     * Set ProgramId
     *
     * @param string $program_id Program ID
     * @return OrderListService Service
     */
    public function setProgramId($program_id)
    {
        $this->orders->programid = $program_id;
        return $this;
    }

    /**
     * Get ProgramId
     *
     * @return string ProgramId
     */
    public function getProgramId()
    {
        return $this->orders->programid;
    }

    /**
     * Get Orders
     *
     * @return object Orders
     */
    public function getOrders()
    {
        return $this->orders;
    }

}
