<?php
namespace Ktcrain\VirtualIncentives\Service;

class OrderService extends AbstractService
{
    /**
     * Value
     *
     * @var string
     */
    protected $value;

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
        $this->getBody()->set('order', (object) []);
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
     *
     * @return OrderService Service
     */
    public function setOrder($program_id, $accounts = [])
    {
        /*
            {  
               "order":{  
                  "programid":"26490",
                  "clientid":"56258125",
                  "accounts":[  
                     {  
                        "firstname":"John",
                        "lastname":"Doe",
                        "email":"john.doe@example.com",
                        "sku":"UVC-V-A06",
                        "amount":"10.00"
                     }
                  ]
               }
            }
        */

        $this->order = (object) [
            'programid' => $program_id,
            'clientid' => $this->generateClientId(),
            'accounts' => $accounts,
        ];

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
        /*
             {  
                "firstname":"John",
                "lastname":"Doe",
                "email":"john.doe@example.com",
                "sku":"UVC-V-A06",
                "amount":"10.00"
             }
        */

        $this->order->accounts[] = $account;

        return $this;
    }

}
