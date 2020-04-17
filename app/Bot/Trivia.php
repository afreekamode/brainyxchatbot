<?php

namespace App\Bot;

use Dotenv\Result\Result;
use Illuminate\Support\Facades\Cache;

class Trivia
{
    public static $NEW_QUESTION = "new";
    public static $NEW_ANIMAL = "animal";
    public static $NEW_MATHS = "maths";
    public static $NEW_SPORT = "sport";
    public static $NEW_CATOON = "catoon";
    public static $NEW_MOVIE = "movie";
    public static $NEW_BYE = "bye";
    public static $NEW_HELLO = "hello";
    public static $NEW_HI = "hi";
    public static $ANSWER = "answer";

    private $question;
    private $options;
    private $solution;

    public function __construct(array $data)
    {
        $this->question = $data["question"];
        $answer = $data["correct_answer"];
        $this->options = array_slice($data["incorrect_answers"], 0, 2);
        $this->options[] = $answer;
        shuffle($this->options);
        $this->solution = $answer;
    }

    public static function getNew()
    {
        //clear any past solutions left in the cache
        Cache::forget("solution");

        //make API call and decode result to get general-knowledge trivia question
        $ch = curl_init("https://opentdb.com/api.php?amount=1&category=9&type=multiple");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = json_decode(curl_exec($ch), true)["results"][0];

        return new Trivia($result);
    }

    public static function getAnimal()
    {
        //clear any past solutions left in the cache
        Cache::forget("solution");

        //make API call and decode result to get general-knowledge trivia question
        $ch = curl_init("https://opentdb.com/api.php?amount=1&category=27&type=multiple");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = json_decode(curl_exec($ch), true)["results"][0];

        return new Trivia($result);
    }
    public static function getMaths()
    {
        //clear any past solutions left in the cache
        Cache::forget("solution");

        //make API call and decode result to get general-knowledge trivia question
        $ch = curl_init("https://opentdb.com/api.php?amount=1&category=19&type=multiple");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = json_decode(curl_exec($ch), true)["results"][0];

        return new Trivia($result);
    }
    public static function getSport()
    {
        //clear any past solutions left in the cache
        Cache::forget("solution");

        //make API call and decode result to get general-knowledge trivia question
        $ch = curl_init("https://opentdb.com/api.php?amount=1&category=21&type=multiple");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = json_decode(curl_exec($ch), true)["results"][0];

        return new Trivia($result);
    }
    public static function getCatoon()
    {
        //clear any past solutions left in the cache
        Cache::forget("solution");

        //make API call and decode result to get catoon trivia question
        $ch = curl_init("https://opentdb.com/api.php?amount=1&category=32&type=multiple");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = json_decode(curl_exec($ch), true)["results"][0];

        return new Trivia($result);
    }
    public static function getMovie()
    {
        //clear any past solutions left in the cache
        Cache::forget("solution");

        //make API call and decode result to get catoon trivia question
        $ch = curl_init("https://opentdb.com/api.php?amount=1&category=11&type=multiple");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = json_decode(curl_exec($ch), true)["results"][0];

        return new Trivia($result);
    }
    
    public static function getHello()
    {
        $response = 'Hi Welcome to BrainyX ! would you like to refresh your mind? Then check the following options';
        $solution = Cache::get("solution");
        Cache::forget("solution");
        return [
            "text" => $response,
            "quick_replies" => [
                [
                    "content_type" => "text",
                    "title" => "General questions",
                    "payload" => "new"
                ],
                [
                    "content_type" => "text",
                    "title" => "Catoon questions",
                    "payload" => "catoon"
                ], [
                    "content_type" => "text",
                    "title" => "Maths questions",
                    "payload" => "maths"
                ],
                [
                    "content_type" => "text",
                    "title" => "Sport questions",
                    "payload" => "sport"
                ],
                [
                    "content_type" => "text",
                    "title" => "Movie questions",
                    "payload" => "movie"
                ],
                [
                    "content_type" => "text",
                    "title" => "Animal questions",
                    "payload" => "animal"
                ]
            ]
        ];
    }

    public static function getByeMsg()
    {
        $response = 'Byee see you around !';
        $solution = Cache::get("solution");
        Cache::forget("solution");
        return [
            "text" => $response,
            "quick_replies" => [
                [
                    "content_type" => "text",
                    "title" => "More questions",
                    "payload" => "new"
                ]
            ]
        ];
    }


    public static function checkAnswer($answer)
    {
        $solution = Cache::get("solution");
        if ($solution == strtolower($answer)) {
            $response = "Correct!";
        } else {
            $response = "Wrong. Correct answer is $solution";
        }
        //clear solution
        Cache::forget("solution");
        return [
            "text" => $response,
            "quick_replies" => [
                [
                    "content_type" => "text",
                    "title" => "New question",
                    "payload" => "new"
                ],
                [
                    "content_type" => "text",
                    "title" => "Maths questions",
                    "payload" => "maths"
                ],
                [
                    "content_type" => "text",
                    "title" => "Sport questions",
                    "payload" => "sport"
                ],
                [
                    "content_type" => "text",
                    "title" => "Animal questions",
                    "payload" => "animal"
                ],
                [
                    "content_type" => "text",
                    "title" => "Catoon questions",
                    "payload" => "catoon"
                ],
                [
                    "content_type" => "text",
                    "title" => "Movie questions",
                    "payload" => "movie"
                ],
                [
                    "content_type" => "text",
                    "title" => "Thank you, bye !",
                    "payload" => "bye"
                ]
            ]
        ];
    }

    public function toMessage()
    {
        //compose message
        $text = htmlspecialchars_decode("Question: $this->question", ENT_QUOTES | ENT_HTML5);

        $response = [
            "attachment" => [
                "type" => "template",
                "payload" => [
                    "template_type" => "button",
                    "text" => $text,
                    "buttons" => []
                ]
            ]
        ];

        $letters = ["a", "b", "c", "d"];
        foreach ($this->options as $i => $option) {
            $response["attachment"]["payload"]["buttons"][] = [
                "type" => "postback",
                "title" => "{$letters[$i]}:" . htmlspecialchars_decode($option, ENT_QUOTES | ENT_HTML5),
                "payload" => "{$letters[$i]}"
            ];
            if($this->solution == $option) {
                Cache::forever("solution", $letters[$i]);
            }
        }

        return $response;
    }
}
