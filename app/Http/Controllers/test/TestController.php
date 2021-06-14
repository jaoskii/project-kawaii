<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google;

class TestController extends Controller{

    private $influencers;
    private $youtube_client;
    private $instagram_client;

    public function __construct() {
        $this->influencers = include(app_path().'/Imports/influencers.php');
        $this->youtube_client = Google::make("youtube");
        $this->instagram_client = new \InstagramScraper\Instagram(new \GuzzleHttp\Client());
    }//end construct

    public function youtubeSandbox(){
        try {
            
            $queryParams = [
                'channelId' => 'UCslLr5lY-sVfxDEruDGURYA',
                'type' => 'video',
                'order' => 'date',
                'maxResults' => 50
            ];

            $searchResults = $this->youtube_client->search->listSearch('snippet', $queryParams);

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

    public function instagramScrapperv1(){
        

        // For getting information about account you don't need to auth:

        $account = $this->instagram_client->getAccount('lambofgod');

        // Available fields
        echo "Account info:<br>";
        echo "Id: {$account->getId()}<br>";
        echo "Username: {$account->getUsername()}<br>";
        echo "Full name: {$account->getFullName()}<br>";
        echo "Biography: {$account->getBiography()}<br>";
        echo "Profile picture url: {$account->getProfilePicUrl()}<br>";
        echo "External link: {$account->getExternalUrl()}<br>";
        echo "Number of published posts: {$account->getMediaCount()}<br>";
        echo "Number of followers: {$account->getFollowsCount()}<br>";
        echo "Number of follows: {$account->getFollowedByCount()}<br>";
        echo "Is private: {$account->isPrivate()}<br>";
        echo "Is verified: {$account->isVerified()}<br>";

        echo '<br><br><br>';

        $medias = $this->instagram_client->getMedias('lambofgod', 25);

        // Let's look at $media

        foreach ($medias as $key => $value) {
            $media = $medias[$key];
            echo "Media info:<br>";
            echo "Id: {$media->getId()}<br>";
            echo "Shortcode: {$media->getShortCode()}<br>";
            echo "Created at: {$media->getCreatedTime()}<br>";
            echo "Caption: {$media->getCaption()}<br>";
            echo "Number of comments: {$media->getCommentsCount()}<br>";
            echo "Number of likes: {$media->getLikesCount()}<br>";
            echo "Get link: {$media->getLink()}<br>";
            echo "High resolution image: {$media->getImageHighResolutionUrl()}<br>";
            echo "Media type (video or image): {$media->getType()}";
            echo "<br><br><br>";
        }//end for each
    }//end fn


    public function initialPage(){
        try {
            foreach ($this->influencers as $key => $value) {
                echo '<h4>' . $value['name'] . ' - <a href="kawaii/'.$key.'">View</a></h4>';
            }//end for each
        } catch (Exception $e) {
            echo $e;
        }   
    }//end fn

    public function pkDetails(Request $request,$pkid){
        $influencer_details = $this->influencers[$pkid];
        try {
            echo '<h1>YOUTUBE</h1>';
            $queryParams = [
                'channelId' => $influencer_details['youtube_channelid'],
                'type' => 'video',
                'order' => 'date',
                'maxResults' => 5
            ];

            $searchResults = $this->youtube_client->search->listSearch('snippet', $queryParams);

            foreach ($searchResults as $playlistItem) {
                $url = 'https://www.youtube.com/watch?v='. $playlistItem->id['videoId'];
                $thumbnail = $playlistItem['snippet']['thumbnails']['default']['url'];
                echo '<img src="'.$thumbnail.'" height="'.$playlistItem['snippet']['thumbnails']['default']['height'].'" width = "'.$playlistItem['snippet']['thumbnails']['default']['width'].'"><br>';
                echo '<b><h3>'.$playlistItem->snippet['title'] . ' - <a href="'.$url.'">View</a></h3></b>';
                echo '<b>Description: '.$playlistItem->snippet['description'].'</b>';
                echo '<br><br><br><br>';  
            }//end for each


            echo '<h1>INSTAGRAM</h1>';
            $account = $this->instagram_client->getAccount($influencer_details['instagram_username']);

            // Available fields
            echo "<b>Account info:</b><br>";
            echo "Id: {$account->getId()}<br>";
            echo "Username: {$account->getUsername()}<br>";
            echo "Full name: {$account->getFullName()}<br>";
            echo "Biography: {$account->getBiography()}<br>";
            echo "Profile picture url: {$account->getProfilePicUrl()}<br>";
            echo "External link: {$account->getExternalUrl()}<br>";
            echo "Number of published posts: {$account->getMediaCount()}<br>";
            echo "Number of followers: {$account->getFollowsCount()}<br>";
            echo "Number of follows: {$account->getFollowedByCount()}<br>";
            echo "Is private: {$account->isPrivate()}<br>";
            echo "Is verified: {$account->isVerified()}<br>";

            echo '<br><br><br>';

            $medias = $this->instagram_client->getMedias($influencer_details['instagram_username'], 5);

            // Let's look at $media

            foreach ($medias as $key => $value) {
                $media = $medias[$key];
                echo "<b>Media info / Posts:</b><br>";
                echo "Id: {$media->getId()}<br>";
                echo "Shortcode: {$media->getShortCode()}<br>";
                echo "Created at: {$media->getCreatedTime()}<br>";
                echo "Caption: {$media->getCaption()}<br>";
                echo "Number of comments: {$media->getCommentsCount()}<br>";
                echo "Number of likes: {$media->getLikesCount()}<br>";
                echo "Get link: {$media->getLink()}<br>";
                echo "High resolution image: {$media->getImageHighResolutionUrl()}<br>";
                echo "Media type (video or image): {$media->getType()}<br>";
                echo "<a href ='{$media->getLink()}'>View Post</a>";
                echo "<br><br><br>";
            }//end for each
        } catch (Exception $e) {
            echo $e;
        }
    }//end fn
}//enc controller
