<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessangerController extends Controller
{
    public static function search()
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

$result='[{"id":"6lSBynPRaAQ","created_at":"2018-11-16T05:03:27-05:00","updated_at":"2020-04-21T01:22:55-04:00","promoted_at":null,"width":6000,"height":4000,"color":"#F8F6F3","description":null,"alt_description":"gray sports coupe parking during daytime","urls":{"raw":"https://images.unsplash.com/photo-1542362567-b07e54358753?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyOTAxMn0","full":"https://images.unsplash.com/photo-1542362567-b07e54358753?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb&ixid=eyJhcHBfaWQiOjEyOTAxMn0","regular":"https://images.unsplash.com/photo-1542362567-b07e54358753?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max&ixid=eyJhcHBfaWQiOjEyOTAxMn0","small":"https://images.unsplash.com/photo-1542362567-b07e54358753?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjEyOTAxMn0","thumb":"https://images.unsplash.com/photo-1542362567-b07e54358753?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjEyOTAxMn0"},"links":{"self":"https://api.unsplash.com/photos/6lSBynPRaAQ","html":"https://unsplash.com/photos/6lSBynPRaAQ","download":"https://unsplash.com/photos/6lSBynPRaAQ/download","download_location":"https://api.unsplash.com/photos/6lSBynPRaAQ/download"},"categories":[],"likes":195,"liked_by_user":false,"current_user_collections":[],"user":{"id":"-Mn531yIDBU","updated_at":"2020-04-21T20:02:38-04:00","username":"olav_tvedt","name":"Olav Tvedt","first_name":"Olav","last_name":"Tvedt","twitter_username":null,"portfolio_url":"https://www.instagram.com/olav_tvedt/","bio":"Dude from Norway with a camera and some pictures","location":"Norway","links":{"self":"https://api.unsplash.com/users/olav_tvedt","html":"https://unsplash.com/@olav_tvedt","photos":"https://api.unsplash.com/users/olav_tvedt/photos","likes":"https://api.unsplash.com/users/olav_tvedt/likes","portfolio":"https://api.unsplash.com/users/olav_tvedt/portfolio","following":"https://api.unsplash.com/users/olav_tvedt/following","followers":"https://api.unsplash.com/users/olav_tvedt/followers"},"profile_image":{"small":"https://images.unsplash.com/profile-1580416274030-fbb94dfec844image?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=32&w=32","medium":"https://images.unsplash.com/profile-1580416274030-fbb94dfec844image?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64","large":"https://images.unsplash.com/profile-1580416274030-fbb94dfec844image?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=128&w=128"},"instagram_username":"olav_tvedt","total_collections":1,"total_likes":72,"total_photos":38,"accepted_tos":true},"tags":[{"type":"landing_page","title":"car","source":{"ancestry":{"type":{"slug":"images","pretty_slug":"Images"},"category":{"slug":"things","pretty_slug":"Things"},"subcategory":{"slug":"car","pretty_slug":"Car"}},"title":"Car Images & Pictures","subtitle":"Download free car images","description":"Choose from a curated selection of car photos. Always free on Unsplash.","meta_title":"Best 500+ Car Photos [Spectacular] | Download Car Images & Pictures - Unsplash","meta_description":"Choose from hundreds of free car pictures. Download HD car photos for free on Unsplash.","cover_photo":{"id":"m3m-lnR90uM","created_at":"2017-04-14T00:59:12-04:00","updated_at":"2020-03-21T01:02:46-04:00","promoted_at":"2017-04-14T13:20:15-04:00","width":5357,"height":3164,"color":"#E0E4EF","description":"I shot this while doing a job for a luxury automotive storage facility in Baltimore, MD. I wanted to create an ominous sense of intrigue, giving the feeling of a space that was both expansive and enclosed. I enjoy the journey my eyes take from the focal point of the headlamps to the contours of the Camero’s body, and then to the backdrop of stacked automobiles.","alt_description":"white car","urls":{"raw":"https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1","full":"https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1&q=85&fm=jpg&crop=entropy&cs=srgb","regular":"https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max","small":"https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max","thumb":"https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max"},"links":{"self":"https://api.unsplash.com/photos/m3m-lnR90uM","html":"https://unsplash.com/photos/m3m-lnR90uM","download":"https://unsplash.com/photos/m3m-lnR90uM/download","download_location":"https://api.unsplash.com/photos/m3m-lnR90uM/download"},"categories":[],"likes":912,"liked_by_user":false,"current_user_collections":[],"user":{"id":"9aTMQdp_Djo","updated_at":"2020-03-20T22:24:24-04:00","username":"peterbroomfield","name":"Peter Broomfield","first_name":"Peter","last_name":"Broomfield","twitter_username":null,"portfolio_url":"http://workingdesignstudio.com/","bio":null,"location":"Baltimore, MD","links":{"self":"https://api.unsplash.com/users/peterbroomfield","html":"https://unsplash.com/@peterbroomfield","photos":"https://api.unsplash.com/users/peterbroomfield/photos","likes":"https://api.unsplash.com/users/peterbroomfield/likes","portfolio":"https://api.unsplash.com/users/peterbroomfield/portfolio","following":"https://api.unsplash.com/users/peterbroomfield/following","followers":"https://api.unsplash.com/users/peterbroomfield/followers"},"profile_image":{"small":"https://images.unsplash.com/profile-fb-1484539966-12de6566b969.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=32&w=32","medium":"https://images.unsplash.com/profile-fb-1484539966-12de6566b969.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=64&w=64","large":"https://images.unsplash.com/profile-fb-1484539966-12de6566b969.jpg?ixlib=rb-1.2.1&q=80&fm=jpg&crop=faces&cs=tinysrgb&fit=crop&h=128&w=128"},"instagram_username":"pnbroom","total_collections":36,"total_likes":127,"total_photos":1,"accepted_tos":true}}}},{"type":"search","title":"automobile"},{"type":"search","title":"transportation"}]}]';
      // Convert JSON string to Array
  $someArrays = json_decode($result, true);
  foreach ($someArrays as $someArray) {
//   print_r($someArray);        // Dump all data of the Array
  return $someArray["user"]['name']."\n".$someArray["urls"]['thumb']."\n"."@".$someArray["user"]["instagram_username"]."\n".$someArray["links"]['download']; // Access Array data
   }
}

    public static function searchImage($search, $next)
    {
        //clear any past solutions left in the cache
        
        $client_id = env('UNSPLASH_CLIENT_ID');
        //make API call and decode result to get general-knowledge trivia question
        $ch = curl_init("https://api.unsplash.com/search/photos/?query=$search&client_id=$client_id&per_page=30&page=10");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = json_decode(curl_exec($ch), true)['results'][$next];
        if($result>0){
        $imag = $result["urls"]["thumb"];
        $btn =$result["links"]["download"].'?force=true';
        return "Picture by:".$result["user"]["name"]."<br>Instagram: @".$result["user"]["instagram_username"]."<br><img src='$imag'><br><a href='$btn' download>Donwload picture</a><br>"; // Access Array data
        }else{
            return "Nothing found please try nother search term";
        }
    }
}
