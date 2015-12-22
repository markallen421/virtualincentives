<?php
namespace Ktcrain\VirtualIncentives\Service\Body;

interface BodyInterface
{
    /**
     * To String Magic Method
     *
     * @return string Data
     */
    public function __toString();

    /**
     * Set Data
     *
     * @param mixed $data Data
     */
    public function setData($data);

    /**
     * Get Data
     *
     * @return array Data
     */
    public function getData();

    /**
     * Set Data From String
     *
     * @param string $string String
     */
    public function setDataFromString($string);

    /**
     * Get Data As String
     *
     * @return string Data
     */
    public function getDataAsString();

    /**
     * Has
     *
     * @param string $key Key
     *
     * @return boolean Whether the key exists or not
     */
    public function has($key);

    /**
     * Set
     *
     * @param string $key   Key
     * @param mixed  $value Value
     */
    public function set($key, $value);

    /**
     * Get
     *
     * @param string $key Key
     *
     * @return mixed Value
     */
    public function get($key);

}
