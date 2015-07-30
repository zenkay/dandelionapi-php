<?php
namespace Dandelionapi;

use Dandelionapi\apis\EntityExtraction;

class Dandelionapi{

    protected $config=[];

    /**
     * @param $apiId id
     * @param $apiKey key
     */
    public function __construct($apiId,$apiKey)
    {
        $this->config['appId']  = $apiId;
        $this->config['appKey'] = $apiKey;
    }


    /**
     * @param array $config
     * @return \stdClass torna un oggetto prodotto dal JSON
     * @throws \Exception
     */
    public function EntityExtraction($config = []){
        // i valori passati per parametro fanno l'override del default
        $_config = array_merge($this->config,$config);
        $_o = new EntityExtraction($_config);

        try{
            $_rv = $_o->run();
        } catch(\Exception $e){
            throw $e;
        }
        return $_rv;
    }
}