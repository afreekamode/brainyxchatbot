<?php

namespace App\Bot;


use App\Bot\Webhook\Messaging;
use Illuminate\Support\Facades\Log;

class Bot
{
    private $messaging;

    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    public function extractData()
    {
        $type = $this->messaging->getType();
        if ($type == "message") {
            return $this->extractDataFromMessage();
        } else if ($type == "postback") {
            return $this->extractDataFromPostback();
        }
        return [];
    }

    public function extractDataFromMessage()
    {
        $matches = [];

        $qr = $this->messaging->getMessage()->getQuickReply();
        if (!empty($qr)) {
            $text = $qr["payload"];
        } else {
            $text = $this->messaging->getMessage()->getText();
        }
        //single letter message means an answer
        if (preg_match("/^(\\w)\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$ANSWER,
                "data" => [
                    "answer" => $matches[0]
                ]
            ];
        } else if (preg_match("/^(new|next)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_QUESTION,
                "data" => []
            ];
        }else if (preg_match("/^(catoon|next)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_CATOON,
                "data" => []
            ];
        }else if (preg_match("/^(maths|next)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_MATHS,
                "data" => []
            ];
        }else if (preg_match("/^(sport|next)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_SPORT,
                "data" => []
            ];
        } else if (preg_match("/^(animal|next)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_ANIMAL,
                "data" => []
            ];
        }else if (preg_match("/^(bye|next)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_BYE,
                "data" => []
            ];
        }else if (preg_match("/^(hello|next)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_HELLO,
                "data" => []
            ];
        }else if (preg_match("/^(hi|next)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_HI,
                "data" => []
            ];
        }
        return [
            "type" => "unknown",
            "data" => []
        ];
    }

    public function extractDataFromPostback()
    {
        $payload = $this->messaging->getPostback()->getPayload();

        if (preg_match("/^(\\w)\$/i", $payload)) {
            return [
                "type" => Trivia::$ANSWER,
                "data" => [
                    "answer" => $payload
                ]
            ];
        } else if ($payload === "get-started") {
            return [
                "type" => "get-started",
                "data" => []
            ];
        }else if ($payload === "get-animal") {
            return [
                "type" => "get-animal",
                "data" => []
            ];
        }else if ($payload === "catoon") {
            return [
                "type" => "catoon",
                "data" => []
            ];
        }else if ($payload === "sport") {
            return [
                "type" => "sport",
                "data" => []
            ];
        }else if ($payload === "maths") {
            return [
                "type" => "maths",
                "data" => []
            ];
        }else if ($payload === "bye") {
            return [
                "type" => "bye",
                "data" => []
            ];
        }
        return [
            "type" => "unknown",
            "data" => []
        ];
    }

    public function sendWelcomeMessage()
    {
        $name = $this->getUserDetails()["first_name"];
        $this->reply("Hi there, $name! Welcome I am BrainyX! You can type \"new\" to get a new question, but why don’t we start with this one?");
    }

    private function getUserDetails()
    {
        $id = $this->messaging->getSenderId();
        $ch = curl_init("https://graph.facebook.com/v2.6/$id?access_token=" . env("PAGE_ACCESS_TOKEN"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

        return json_decode(curl_exec($ch), true);
    }

    public function reply($data)
    {
        if (method_exists($data, "toMessage")) {
            $data = $data->toMessage();
        } else if (is_string($data)) {
            $data = ["text" => $data];
        }
        $id = $this->messaging->getSenderId();
        $this->sendMessage($id, $data);
    }

    private function sendMessage($recipientId, $message)
    {
        $messageData = [
            "recipient" => [
                "id" => $recipientId
            ],
            "message" => $message
        ];
        $ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token=' . env("PAGE_ACCESS_TOKEN"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
        Log::info(print_r(curl_exec($ch), true));
    }
}