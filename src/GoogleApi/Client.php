<?php

namespace GoogleApi;

class Config {
    static $API_KEY;

    static function setKey($key){
        self::$API_KEY = $key;
    }
}

class Client {

    public $client;

    public $endpoint;

    public $base_uri = 'https://www.googleapis.com';

    public $format = "json";

    public function __construct($key = null){
        if ($key){
            Config::setKey($key);
        }
        $this->client = new \Guzzle\Http\Client($this->base_uri . "?key=$key");
        $this->client->setDefaultHeaders(array('Content-Type' => 'application/json'));
    }

    public function get($endpoint, $params = array()){
        return $this->request('get', $endpoint, $params);
    }

    public function post($endpoint, $params = array(), $body = null){
        return $this->request('post', $endpoint, $params, $body);
    }

    public function request($method = 'get', $endpoint, $params, $body = null){
        $endpoint = $this->endpoint . $endpoint;
        //$params['key'] = Config::$API_KEY;

        $qs = ($params) ? "?" . http_build_query($params) : "";

        if ($method == 'get'){
            $request = $this->client->get($endpoint . $qs)->send();
        } elseif ($method == 'post') {
            $request = $this->client->post($endpoint, null, $body)->send();
        } else {
            throw new \Exception("Unsupported request method");
        }

        if ($this->format == 'json'){
            return $request->json();
        } else {
            return $request->getBody();
        }

    }
}

class CivicInfo extends Client {
    public $endpoint = "civicinfo/us_v1/";

    public function elections(){
        return $this->get('elections');
    }

    public function voterInfo($election_id, $params = array(), $body = null){
        if ($body){
            $body = json_encode($body);
        }
        return $this->post("voterinfo/$election_id/lookup", $params, $body);
    }
}