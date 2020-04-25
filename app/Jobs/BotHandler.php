<?php

namespace App\Jobs;

use App\Bot\Bot;
use App\Bot\Trivia;
use App\Bot\Webhook\Messaging;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class BotHandler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messaging;

    /**
     * Create a new job instance.
     *
     * @param Messaging $messaging
     */
    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        $bot = new Bot($this->messaging);
        $custom = $bot->extractData();

        //a request for a new question
        if ($custom["type"] == Trivia::$NEW_QUESTION) {
            $bot->reply(Trivia::getNew());
        }else if ($custom["type"] == Trivia::$NEW_MENU) {
            $bot->reply(Trivia::getMenu());
        }else if ($custom["type"] == Trivia::$NEW_ANIMAL) {
            $bot->reply(Trivia::getAnimal());
        }else if ($custom["type"] == Trivia::$NEW_MATHS) {
            $bot->reply(Trivia::getMaths());
        }else if ($custom["type"] == Trivia::$NEW_CATOON) {
            $bot->reply(Trivia::getCatoon());
        }else if ($custom["type"] == Trivia::$NEW_MOVIE) {
            $bot->reply(Trivia::getMovie());
        }else if ($custom["type"] == Trivia::$NEW_SPORT) {
            $bot->reply(Trivia::getSport());
        } else if ($custom["type"] == Trivia::$ANSWER) {
            if (Cache::has("solution")) {
                $bot->reply(Trivia::checkAnswer($custom["data"]["answer"]));
            } else {
                $bot->reply("Looks like that question has already been answered. Please try \"new\" or \"animal\" for a new question");
            }
        } else if ($custom["type"] == "get-started") {
            $bot->sendWelcomeMessage();
            $bot->reply(Trivia::getNew());
        }else if ($custom["type"] == "get-animal") {
            $bot->sendWelcomeMessage();
            $bot->reply(Trivia::getAnimal());
        }else if ($custom["type"] == Trivia::$NEW_BYE) {
            $bot->reply(Trivia::getByeMsg());
        }else if ($custom["type"] == Trivia::$NEW_HELLO || $custom["type"] == Trivia::$NEW_HI) {
                $bot->reply(Trivia::getHello());
        }else if ($custom["type"] == Trivia::$NEW_GREET){
            if($custom["text"]=="good night"){
            $bot->reply("Good night and have a wonderfull dreams!");
            }else{
            $bot->reply(Trivia::getGreet($custom["text"]));
            }
        }else if ($custom["type"] == Trivia::$NEW_SRCH_IMG){
            $bot->reply(Trivia::searchIMG());
        }else if ($custom["type"] == Trivia::$NEW_IMAGE){
            $img = $custom["text"];
            $bot->reply("Here are some $img pictures");
            $next = Cache::get("nextBtn");
            $bot->reply(Trivia::newImage($img,$next));
        }else if ($custom["type"] == Trivia::$NEXT_IMAGE){
            $next = Cache::get("nextBtn");
            $img = $custom["text"];
            $bot->reply(Trivia::nextImage($img,$next));
        }else if ($custom["type"] == "yes" || $custom["type"] == "yes i wanna play game" || $custom["type"] == "yes i want to play game" || $custom["type"] == 'wanna play' || $custom["type"] == 'lets play game' || $custom["type"] == 'lets play') {
            $bot->reply("Ok fine pick your choice from the menu");
            $bot->reply(Trivia::getMenu());
        } else {
            $bot->reply("I don't understand. Please try \"new\" or \"animal\" for a new question");
        }
    }
}