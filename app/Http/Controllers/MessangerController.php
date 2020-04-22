<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessangerController extends Controller
{
    // public function webhook(){
    //     $local_verify_token = env('WEBHOOK_VERIFY_TOKEN');
    //     $hub_verify_token = \Input::get('hub_verify_token');
    //     if($local_verify_token == $hub_verify_token){
    //         return \Input::get('hub_challenge');
    //     }else{
    //         return "Bad verify token";
    //     }
    // }
    public static function search($search)
    {
        // //clear any past solutions left in the cache
        // Cache::forget("solution");
        // $client_id = env('UNSPLASH_CLIENT_ID');
        // //make API call and decode result to get general-knowledge trivia question
        // $ch = curl_init("https://api.unsplash.com/search/photos/?query=$search&client_id=$client_id&page=1&rel='first'&rel='next'");
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // $result = json_decode(curl_exec($ch), true)["results"][0];

        // return new Trivia($result);
    }

}
