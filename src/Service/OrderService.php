<?php
namespace Ktcrain\VirtualIncentives\Service;

class OrderService extends AbstractService
{
    /**
     * Order
     *
     * @var object
     */
    protected $order;

    /**
     * Endpoint
     *
     * @var string
     */
    protected $endpoint = 'order';

    /**
     * Configure
     *
     * @return void
     */
    public function configure()
    {
        $this->order = (object) [
            'programid' => null,
            'clientid' => $this->generateClientId(),
            'accounts' => [],
        ];
    }

    /**
     * Prepare
     *
     * @return void
     */
    public function prepare()
    {
        $this->getBody()->set('order', $this->order);
    }

    /**
     * Set Order
     *
     * @param string $program_id Program ID
     * @param array $accounts Accounts
     * @return OrderService Service
     */
    public function setOrder($program_id, $accounts = [])
    {
        $this->order->programid = $program_id;
        $this->order->accounts = $accounts;
        return $this;
    }

    /**
     * Set ProgramId
     *
     * @param string $program_id Program ID
     * @return OrderService Service
     */
    public function setProgramId($program_id)
    {
        $this->order->programid = $program_id;
        return $this;
    }

    /**
     * Get Order
     *
     * @return object Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Add Account
     *
     * @param object $account Account
     *
     * @return OrderService Service
     */
    public function addAccount($account)
    {
        $this->order->accounts[] = $account;

        return $this;
    }

}
