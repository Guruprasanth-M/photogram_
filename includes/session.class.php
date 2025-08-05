<?php

class session{
    public static function start() {
        // Restrict session cookie to /app/ path
        session_set_cookie_params([
            'lifetime' => 0,                // Cookie expires when browser closes
            'path' => '/app/',              // Limits session to /app/ and below
            'domain' => $_SERVER['HTTP_HOST'], // Keeps it valid for current host
            'secure' => isset($_SERVER['HTTPS']), // HTTPS only if connection is secure
            'httponly' => true,             // JS cannot access session cookie
            'samesite' => 'Strict'          // Blocks CSRF-like requests
        ]);

        session_start();
    }

    public static function unset(){
        session_unset();
    }

    public static function destroy(){
        session_destroy();
    }
    public static function set($key,$value){
        $_SESSION[$key] = $value;
    }
    public static function delete($key){
        unset($_SESSION[$key]);
    }
    public static function isset($key){
        return isset($_SESSION[$key]);
    }
    public static function get($key,$default=false){
        if(session::isset($key)){
        return $_SESSION[$key];
        }else{
            return $default;
        }

    }
}