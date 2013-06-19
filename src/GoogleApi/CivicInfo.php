<?php

namespace GoogleApi;

class CivicInfo extends Client {
    public $endpoint = "civicinfo/us_v1/";

    public function elections(){
        return $this->get('elections');
    }

    public function voterInfo($election_id, $body = null){
        if ($body){
            $body = json_encode($body);
        }
        return $this->post("voterinfo/$election_id/lookup", null, $body);
    }
}