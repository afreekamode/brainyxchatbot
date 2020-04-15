<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Message;

class MainController extends Controller
{
    public function webhook(Request $request)
    {
        $data = $request->all();
        $id = $data["entry"][0]["messaging"][0]["sender"]["id"];
        $senderMessage = $data["entry"][0]["messaging"][0]["message"];
        if(!empty($senderMessage)){
            $this->sendTextMessage($id, "Hi Buddy");
        }
    }

    private function sendTextMessage($recipientId, $messageText)
    {
        $messageData = [
            "recipient" => [
                "id"=> $recipientId,
            ],
            "message" => [
                "text"=> $messageText,
            ],
        ];
        $curl = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token=' . env("PAGE_ACCESS_TOKEN"));
        curl_setopt_array($curl, array(
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($messageData),
        ));

        curl_exec($curl);
        curl_close($curl);
    }
}
