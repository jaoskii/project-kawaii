<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google;

class TestController extends Controller{
    
    private $google_client;
    
    public function KawaiiSanbox(){
        try {
            $youtube = Google::make("youtube");
            $queryParams = [
                'channelId' => 'UCslLr5lY-sVfxDEruDGURYA',
                'type' => 'video',
                'order' => 'date',
                'maxResults' => 50
            ];

            $searchResults = $youtube->search->listSearch('snippet', $queryParams);

            //string(4) "etag" string(4) "kind" string(2) "id" string(7) "snippet"
            foreach ($searchResults as $playlistItem) {
                $url = 'https://www.youtube.com/watch?v='. $playlistItem->id['videoId'];
                $thumbnail = $playlistItem['snippet']['thumbnails']['default']['url'];
                echo '<img src="'.$thumbnail.'" height="'.$playlistItem['snippet']['thumbnails']['default']['height'].'" width = "'.$playlistItem['snippet']['thumbnails']['default']['width'].'"><br>';
                echo '<b><h3>'.$playlistItem->snippet['title'] . ' - <a href="'.$url.'">View</a></h3></b>';
                echo '<b>Description: '.$playlistItem->snippet['description'].'</b>';
                echo '<br><br><br><br>';  
              }
        } catch (Exception $e) {
            echo $e;
        }
    }//ed fn

    public function instaOauth(){
        echo 'test instagram oath';
    }

    public function instaDauth(){
        echo 'test instagram doath';
    }

    public function removeInstaData(){
        echo 'test remove insta data';
    }//end f


    public function instaScrapper(){
        $my_account = 'lambofgod'; 

        //Do the deed
        $results_array = $this->scrape_insta($my_account);

       //An example of where to go from there
        $latest_array = $results_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
       

        foreach ($latest_array as $key => $value) {
            var_dump($value);
            echo "<br><br><br><br>";
        }


        /*echo 'Latest Photo:<br/>';
        echo '<a href="http://instagram.com/p/'.$latest_array['code'].'"><img src="'.$latest_array['display_src'].'"></a></br>';
        echo 'Likes: '.$latest_array['likes']['count'].' - Comments: '.$latest_array['comments']['count'].'<br/>';*/
    }

    function scrape_insta($username) {
        $insta_source = file_get_contents('http://instagram.com/'.$username);
        $shards = explode('window._sharedData = ', $insta_source);
        $insta_json = explode(';</script>', $shards[1]); 
        $insta_array = json_decode($insta_json[0], TRUE);
        return $insta_array;
    }
}
