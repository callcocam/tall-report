<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Tall\Report\Services;

use Tall\Report\Services\Exceptions\ServiceException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tall\Report\Services\Traits\ConsumerExternalService;
use Illuminate\Support\Facades\Auth;

abstract class AbstractServices
{
    use ConsumerExternalService;

    protected $credentials;
    protected $remove = [];

    protected $object;
    protected $json;
    protected $body;
    protected $success= false;

    public function __construct()
    {
            
        $this->token(config('report.api.token'));
        
        $this->baseUri = config('report.api.url');
        
    }

    public static function make(): AbstractServices
    {
        return new static();
    }

    protected function data($data=[]){


        return $data;
    }
    /**
     * @param array $data
     * @return \Illuminate\Http\Client\Response
     */
    public function get($data = [])
    {

        $response = $this->request()
        ->get($this->getBaseUri(), array_merge($this->data($data), $data));
        if ($response->successful()) {
            $this->json = $response->json();
            $this->object = $response->object();
            $this->body = $response->body();
            $this->success = (bool)$response->ok();
            return $response->object();
        }
        return $response;
    }

    public function store($data=[])
    {
        $data = $this->data($data);
        Arr::forget($data,$this->remove);

        $response = $this->request()->post($this->getBaseUri(), $data);
        if ($response->successful()) {
            $this->json = $response->json();
            $this->object = $response->object();
            $this->body = $response->body();
            $this->success = (bool)$response->object()->Success;
            return $response;
        }
        return $response->throw();
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return mixed
     */
    public function getJson($key = null)
    {
        if($key)
            return $this->json[$key];

        return $this->json;
    }

    /**
     * @return mixed
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }


    public function user(){

        return Auth::user();
    }

    /**
     * @param $data
     * @param $model
     * @return array
     */
    public function logs($data,  $model){
        $data = $this->data($data);
        foreach ($data as $key => $value) {
            if(is_array($value)){
                $value= json_encode($value);
            }
            $model->log()->create([
                "name"=>$key,
                "description"=>$value
            ]);
        }
        return $data;
    }
}
