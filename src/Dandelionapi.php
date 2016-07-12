<?php
namespace Dandelionapi;

use Dandelionapi\apis\EntityExtraction;

class Dandelionapi{

    protected $config=[];

    /**
     * @param array|string $credentials use to set the token or (apiId and apiKey)
     *                                  of your DandelionAPI account.
     */
    public function __construct($credentials)
    {
        if (is_string($credentials)) {
            $this->config['token'] = $credentials;
        } else {
            $this->config['token'] = @$credentials['token'] ?: null;
            $this->config['appId'] = @$credentials['appId'] ?: null;
            $this->config['appKey'] = @$credentials['appKey'] ?: null;
        }
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