<?php

class Spotify {

    private function check($track) {

        //Set the base URL for searching.
        $base = "ws.spotify.com/search/1/track.json";

        $track = implode("+", $track);

        //Talk to the spotify API to return some json yumminess.
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $base . "?q=" . $track);

        $output = curl_exec($ch);

        curl_close($ch);

        //Decode the json into an array.
        $output = json_decode($output,true);

        //If there are no results for the track.
        if ($output['info']['num_results'] == '0') {

            return false;

        } else {

            return true;

        }

    }

    public function trackid($track) {

        //Set the base URL for searching.
        $base = "ws.spotify.com/search/1/track.json";

        //Turn the track into a '+' seperated string.
        $track = explode(' ', $track);
        $track = implode('+', $track);

        //Talk to the spotify API to return some json yumminess.
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $base . "?q=" . $track);

        $output = curl_exec($ch);

        curl_close($ch);

        //Decode the json into an array.
        $output = json_decode($output,true);

        //If there are results for the track.
        if (!$output['info']['num_results'] == '0') {

            //Grab the first result in the array (the most popular).
            $output = $output['tracks'][0];
            $trackid = $output['href'];

            return $trackid;

        }

    }

    public function add_to_playlist($trackid,$playlist) {

        //Post the trackid to the api server listening on localhost.
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"localhost:1337/playlist/" . $playlist . "/add?index");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "[\"" . $trackid . "\"]");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        curl_close ($ch);

        return $output;

    }

    private function youtube_title($url) {

        $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);

        $output = curl_exec($ch);

        curl_close($ch);

        preg_match("/\<title.*\>(.*)\<\/title\>/", $output, $matches);

        $output = $matches[1];

        $output = str_replace('- YouTube', '', $output);
        $output = str_replace('&amp;', '', $output);
        $title = preg_replace('/[^A-Za-z0-9\s]/', '', $output);

        return $title;

    }

    private function youtube_to_spotify_title($video_url) {

        $youtube_title = $this->youtube_title($video_url);

        $youtube_title_array = array_filter(explode(' ', $youtube_title));

        $check = false;
        $count = 0;
        while ($check != true) {

            if (empty($youtube_title_array)) { break; }

            if (!$this->check($youtube_title_array)) {

                array_pop($youtube_title_array);
                $check = false;
                $count++;

            } else {

                $check = true;

            }

        }

        if ($count > 4) { return false; }

        if (!empty($youtube_title_array)) {

            $spotify_search = implode(' ', $youtube_title_array);

            return $spotify_search;

        } else {

            return false;

        }
    
    }

    public function youtube($url) {

        $trackname = $this->youtube_to_spotify_title($url);

        $trackid = $this->trackid($trackname);

        return $trackid;

    }

}