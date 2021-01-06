<?php

use App\Models\Exhibition;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if(!function_exists('format_date')){
    function format_date(?string $str) : string
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


if(!function_exists('format_datetime')){
    function format_datetime(?string $str) : string
    {
        if($str == null){
            return "chyba";
        }
        try{
//            TODO: fix time
            return (new  Carbon($str))->isoFormat("D. M. YYYY HH:mm:ss");
        } catch(Exception $e){
            return "chyba";
        }
    }
}

if(!function_exists('format_time')){
    function format_time(?string $str) : string
    {
        if($str == null){
            return "chyba";
        }
        try{
            return (new  Carbon($str))->isoFormat("HH:mm");
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

if(!function_exists('format_date_year')){
    function format_date_year(?string $str) : string
    {
        try{
            return (new  Carbon($str))->isoFormat("YYYY");
        } catch(Exception $e){
            return "chyba";
        }
    }
}


if(!function_exists('format_now')){
    function format_now($fmt) : string
    {
        try{
            return Carbon::now()->isoFormat($fmt);
        } catch(Exception $e){
            return "chyba";
        }
    }
}

if(!function_exists('fix_url')){
    function fix_url(?string $str) : string
    {
        if($str == null){
            return "#";
        }

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

if(!function_exists("parse_time_string")){
    // returns ["hours" => parsed_hours, "minutes" => parsed_minutes]
    function parse_time_string(string $src) : ?array
    {
        $matches = [];

        if(preg_match("/(?<hours>\d{1,2}):(?<minutes>\d{1,2})/", $src, $matches)){
            return [
                'hours' => intval($matches['hours']),
                'minutes' => intval($matches['minutes']),
            ];
        } else{
            return null;
        }
    }
}

if(!function_exists("calc_price")){
    function calc_price(int $school_id, int $exhibition_id, $nth = 0)
    {
        $sch = \App\Models\School::findOrFail($school_id);

        if($sch->type_has_free_exhibitions()){
            return 0;
        }

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

        return $exhibition->price;
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

if(!function_exists("html_clean")){
    function html_clean($html)
    {
        $in = "<div>" . $html . "</div>"; // wrap all in div, needs wrapper element or it will extend first tag to wrap whole thing`

        $dom = new DOMDocument();

        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($in, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_use_internal_errors(false);


        $script = $dom->getElementsByTagName('script');

        $remove = [];
        foreach($script as $item){
            $remove[] = $item;
        }

        foreach($remove as $item){
            $item->parentNode->removeChild($item);
        }

        $out = html_entity_decode($dom->saveHTML());

        $out = substr($out, 5, -7); // remove the wrapper div

        return $out;
    }
}
