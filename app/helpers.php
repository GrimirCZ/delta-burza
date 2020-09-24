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


if(!function_exists('fix_url')){
    function fix_url(string $str) : string
    {
        if(str_starts_with($str, "http") || str_starts_with($str, "http")){
            return $str;
        }

        return 'https://' . $str;
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

if(!function_exists('settings')){
    function settings($key = null, $default = null)
    {
        if($key === null){
            return app(App\Settings::class);
        }

        return app(App\Settings::class)->get($key, $default);
    }
}

if(!function_exists("rand_str")){
    function rand_str($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for($i = 0; $i < $length; $i++){
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
