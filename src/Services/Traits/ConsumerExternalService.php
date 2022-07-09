<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace Tall\Report\Services\Traits;

use Illuminate\Support\Facades\Http;

trait ConsumerExternalService
{

    protected $token = null;
    protected $baseUri;

    public static function make()
    {
        return new static();
    }

    public function response()
    {


    }

    public function token($token)
    {
        $this->token = $token;
        return $this;
    }


    abstract protected function services();

    /**
     * @return \Illuminate\Http\Client\PendingRequest
     */
    protected function request()
    {
        return Http::withHeaders([
            "Content-Type"=>"application/json",
            "X-Requested-With"=>"XMLHttpRequest"
        ])->withToken( $this->token );
    }


    /**
     * @param $one
     * @return string
     */
    protected function url($url)
    {
        return sprintf("%s/%s", $this->baseUri, $url);
    }
    /**
     * @param $one
     * @return string
     */
    protected function getUrl($one)
    {
        if ($one) {
            return sprintf("%s/%s", $this->getBaseUri(), $one);
        }
        return $this->getBaseUri();
    }
    
    /**
     * @return string
     */
    protected function getBaseUri()
    {
        return $this->baseUri;
    }
}
