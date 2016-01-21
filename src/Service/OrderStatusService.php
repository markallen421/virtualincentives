<?php
namespace Ktcrain\VirtualIncentives\Service;

class OrderStatusService extends AbstractService
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
    protected $endpoint = 'order/status';

    /**
     * Configure
     *
     * @return void
     */
    public function configure()
    {
        $this->orders = (object) [
            'programid' => null,
            'status' => null,
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
     * @return OrderStatusService Service
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
     * Set Status
     *
     * @param string $status status
     * @return OrderStatusService Service
     */
    public function setStatus($status)
    {
        $this->validateStatus($status);
        $this->orders->status = $status;
        return $this;
    }

    /**
     * Get Status
     *
     * @return string status
     */
    public function getStatus()
    {
        return $this->orders->status;
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
