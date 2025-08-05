<?php

class WebAPI{
    public function __construct() {
                // print("server   : ".php_sapi_name());
        Database::getconnection();        
    }

    public function initiateSession(){
        session::start();
        
    }
}