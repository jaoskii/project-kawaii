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
}
