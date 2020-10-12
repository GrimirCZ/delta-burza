<?php

use App\Models\Exhibition;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if(!function_exists('format_date')){
    function format_date(string $str) : string
    {
        if($str == null){
            return "chyba";
        }
        try{
            return (new  Carbon($str))->isoFormat("D. M. YYYY");
        } catch(Exception $e){
            return "chyba";
        }
    }
}

if(!function_exists('format_date_now')){
    function format_date_now() : string
    {
        try{
            return Carbon::now()->isoFormat("D. MM. YYYY");
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

if(!function_exists('fill_number_to_length')){
    function fill_number_to_length($num, $length)
    {
        $str = strval($num);
        return str_pad($str, $length, "0", STR_PAD_LEFT);
    }
}

if(!function_exists("current_date_str")){
    function current_date_str()
    {
        return (new Carbon())->toDateString();
    }
}


if(!function_exists("calc_price")){
    function calc_price(int $school_id, int $exhibition_id, $nth = 0)
    {
        $exhibition = Exhibition::find($exhibition_id);
        $is_first_order = DB::table('schools')
                ->join("orders", "schools.id", "=", "orders.school_id")
                ->join("order_registration", "orders.id", "=", "order_registration.order_id")
                ->join("registrations", "registrations.id", "=", "order_registration.registration_id")
                ->join("exhibitions", "exhibitions.id", "=", "registrations.exhibition_id")
                ->where("exhibitions.organizer_id", "=", "1")
                ->where("schools.id", "=", $school_id)
                ->count("order_registration.id") == 0;

        // if not
        if($exhibition->organizer_id != 1){
            return 0;
        }

        if($nth == 0 && $is_first_order){
            return 0;
        }

        return settings("exhibition_price");
    }
}

if(!function_exists("html_cut")){
    function html_cut($text, $len)
    {
        $str = strip_tags($text);

        $short_str = strrpos(substr($str, 0, $len), " ");

        if($short_str){
            return substr($str, 0, $short_str) . "...";
        } else{
            return $str;
        }

    }
}
