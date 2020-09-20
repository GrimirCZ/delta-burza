<?php

if(!function_exists('format_date')){
    function format_date(string $str) : string
    {
        try{
            return (new  Carbon\Carbon($str))->isoFormat("D. MM. YYYY");
        } catch(Exception $e){
            return "chyba";
        }
    }
}

if(!function_exists('get_ip')){
    function get_ip()
    {
        foreach(array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if(array_key_exists($key, $_SERVER) === true){
                foreach(explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }

        return null;
    }
}
