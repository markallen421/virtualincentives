<?php
namespace Ktcrain\VirtualIncentives\Service\Body;

use Ktcrain\VirtualIncentives\Util\Arr;
use Ktcrain\VirtualIncentives\Service\Body\Exception\InvalidArgumentException;
use Ktcrain\VirtualIncentives\Service\Body\Exception\UnexpectedValueException;

class JsonBody extends AbstractBody
{

    /**
     * Set Data From String
     *
     * @param data $string String
     *
     * @return JsonBody Body
     */
    public function setDataFromString($string)
    {
        $data = json_decode($string, true);

        # do some transforms, maybe?
        /*
        if (Arr::has($data, 'order')) {
            $this->data
        }
        */

        $this->data = $data;
        
        return $this;
    }

    /**
     * Get Data As String
     *
     * @return string Data
     */
    public function getDataAsString()
    {
        $data = $this->data;

        return json_encode($data);
    }


}
