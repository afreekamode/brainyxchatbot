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
        } else if (preg_match("/^(new|next|General|General Knowledge)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_QUESTION,
                "data" => []
            ];
        }else if (preg_match("/^(catoon|Entertainment: Cartoon & Animations)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_CATOON,
                "data" => []
            ];
        }else if (preg_match("/^(maths|Mathematics|Science: Mathematics)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_MATHS,
                "data" => []
            ];
        }else if (preg_match("/^(sport|Sports)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_SPORT,
                "data" => []
            ];
        } else if (preg_match("/^(animal|next|Animals)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_ANIMAL,
                "data" => []
            ];
        }else if (preg_match("/^(movie|Entertainment: Film)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_MOVIE,
                "data" => []
            ];
        }else if (preg_match("/^(bye|good bye | good night)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_BYE,
                "data" => []
            ];
        }else if (preg_match("/^(hello|hello there)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_HELLO,
                "data" => []
            ];
        }else if (preg_match("/^(hi|hi there)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_HI,
                "data" => []
            ];
        }else if (preg_match("/^(menu|next)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_MENU,
                "data" => []
            ];
        }else if (preg_match("/^(good morning|good morning brainy|good afternoon|good afternoon brainy|morning|afternoon|evening|good evening|good night)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_GREET,
                "text" => $text,
                "data" => []
            ];
        }else if (preg_match("/(?:|i need|need)\s*a\s\K[^\.,]+/", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_IMAGE,
                "text" => $matches,
                "data" => []
            ];
        }else if (preg_match("/^(image|pictures|search)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEW_SRCH_IMG,
                "text" => $text,
                "data" => []
            ];
        }else if (preg_match("/^(next pictures|next image|0-9|nextimg)(\s*question)?\$/i", $text, $matches)) {
            return [
                "type" => Trivia::$NEXT_IMAGE,
                "text" => $text,
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
        } else if ($payload === "get-started" || $payload === "General Knowledge") {
            return [
                "type" => "get-started",
                "data" => []
            ];
        }else if ($payload === "get-animal" || $payload === "Animals") {
            return [
                "type" => "get-animal",
                "data" => []
            ];
        }else if ($payload === "catoon" || $payload === "Entertainment: Cartoon & Animations") {
            return [
                "type" => "catoon",
                "data" => []
            ];
        }else if ($payload === "sport" || $payload === "Sports") {
            return [
                "type" => "sport",
                "data" => []
            ];
        }else if ($payload === "movie" || $payload === "Entertainment: Film") {
            return [
                "type" => "movie",
                "data" => []
            ];
        }else if ($payload === "maths" || $payload === "Science: Mathematics") {
            return [
                "type" => "maths",
                "data" => []
            ];
        }else if ($payload === "bye") {
            return [
                "type" => "bye",
                "data" => []
            ];
        }else if ($payload === "greet") {
            return [
                "type" => "greet",
                "data" => []
            ];
        }else if ($payload === "menu") {
            return [
                "type" => "menu",
                "data" => []
            ];
        }else if ($payload === "image") {
            return [
                "type" => "image",
                "data" => []
            ];
        }else if ($payload === "search") {
            return [
                "type" => "search",
                "data" => []
            ];
        }else if ($payload === "nextimg") {
            return [
                "type" => "nextimg",
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
        }else if (is_string($data)) {
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