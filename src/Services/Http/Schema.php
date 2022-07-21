<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Tall\Report\Services\Http;

use Tall\Report\Services\AbstractServices;

class Schema extends AbstractServices
{
    

    protected function services(){
        return "reports";
    }

    
    /**
     * @return string
     */
    protected function getBaseUri()
    {
        return sprintf("%s/%s", $this->baseUri, $this->services());
    }

}
