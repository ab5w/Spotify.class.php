Spotify.class.php
=================

PHP class to interact with Spotify.

#### Usage

Setup:

    <?php 
     
    include 'spotify.class.php';
    
    $spotify = new Spotify();

##### Youtube.

Gets the track ID for the video name, if it can find one.

    $link = 'https://www.youtube.com/watch?v=foTFAE4r6KQ';
    
    $trackid = $spotify->youtube($link);
    
    echo $trackid . "\n";

Output

    spotify:track:04yYAEqnCZaiCZgeDZYzST

##### TrackID.

Gets the track ID for the track name, if it can find one.

    $track = 'bird in a house railroad earth';
    
    $trackid = $spotify->trackid($track);
    
    echo $trackid . "\n";

Output

    spotify:track:1rbVHN9kCEauy7JQ1QnvHa

##### Add to playlist.

Add a track ID to a playlist. Requires 'spotify-api-server' - https://github.com/liesen/spotify-api-server for manipulating playlists.

    $playlist = 'spotify:user:absw:playlist:4iauLCl44LawtDeEHZJUgE';
    $trackid = 'spotify:track:1rbVHN9kCEauy7JQ1QnvHa';
    
    $addtrack = $spotify->add_to_playlist($trackid,$playlist);
    
    print_r(json_decode($addtrack,true));

Associative array output.

    Array
    (
        [creator] => Craig Parker
        [uri] => spotify:user:absw:playlist:4iauLCl44LawtDeEHZJUgE
        [tracks] => Array
            (
                [0] => spotify:track:1rbVHN9kCEauy7JQ1QnvHa
            )
        
        [title] => class example
        [collaborative] =>
        [subscriberCount] => 0
    )


Copyright (C) 2014 Craig Parker craig@ab5w.com

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; If not, see http:www.gnu.org/licenses/.
