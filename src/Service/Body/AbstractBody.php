<?php
namespace Ktcrain\VirtualIncentives\Service\Body;

use Ktcrain\VirtualIncentives\Util\Arr;
//use DateTime;

abstract class AbstractBody implements BodyInterface
{
    /**
     * Data
     *
     * @var array
     */
    protected $data = [];

    /**
     * To String Magic Method
     *
     * @return string Data
     */
    public function __toString()
    {
        return $this->getDataAsString();
    }

    /**
     * Set Data
     *
     * @param mixed $data Data
     *
     * @return BodyInterface Body
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get Data
     *
     * @return mixed Data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Has
     *
     * @param string $key Key
     *
     * @return boolean Whether the key exists or not
     */
    public function has($key)
    {
        return Arr::has($this->data, $key);
    }

    /**
     * Set
     *
     * @param string $key   Key
     * @param mixed  $value Value
     *
     * @return BodyInterface Body
     */
    public function set($key, $value)
    {
        Arr::set($this->data, $key, $value);

        return $this;
    }

    /**
     * Get
     *
     * @param string $key      Key
     * @param mixed  $fallback Default return value
     *
     * @return mixed Value
     */
    public function get($key, $fallback = NULL)
    {
        return Arr::get($this->data, $key, $fallback);
    }

    /**
     * Set Client ID
     *
     * @param string $client_id Client ID
     *
     * @return BodyInterface Body
     */
    public function setClientId($client_id)
    {
        return $this->set('clientid', $client_id);
    }

    /**
     * Get Client ID
     *
     * @param mixed $fallback Default return value
     *
     * @return string client_id Client ID
     */
    public function getClientId($fallback = NULL)
    {
        return $this->get('clientid', $fallback);
    }

}
