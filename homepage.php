<?php

$conn=mysqli_connect("localhost","root","Robin@123","spotify");
if(!$conn)
{
    die("unable to connect database".mysqli_connect_error());
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="this is spotify clone app with basic functionality">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>spotify-clone</title>
    <link rel="stylesheet" href="./designing.css">
</head>
<body>
    <nav class="navigation">
        <ul class="flex">
            <li class="link"><a href="#">HOME</a></li>
            <h1 class="link">Spotify-Clone</h1>
        </ul>
    </nav>
    <section class="TopSongs flex">
        <div class="Songheading flex">
            <h1 style="font-size:3rem;">TOP 10 Songs</h1>
            <a class="addsong">+ Add Song</a>
        </div>
    
            <table class="tableArtist">
                <tr>
                    <th>Artwork</th>
                    <th>Song</th>
                    <th>Date of Realese</th>
                    <th>Artist</th>
                    <th>Rating</th>
                </tr>
                <tr>
                    <td>hello</td>
                    <td>hello</td>
                    <td>hello</td>
                    <td>hello</td>
                    <td>hello</td>
                </tr>
            </table>
    </section>
    <section class="TopArtist flex">
        <div class="Artistheading flex">
            <h1 style="font-size:3rem;">TOP 10 Artists</h1>
        </div>
    
            <table class="tableArtist">
                <tr>
                    <th>Artist</th>
                    <th>Date of Birth</th>
                    <th>Songs</th>
                </tr>
                <tr>
                    <td>hello</td>
                    <td>hello</td>
                    <td>hello</td>
                </tr>
            </table>
    </section>
    <section class="addsongdetails flex">
        <h1 style="font-size:2.5rem;padding:2rem 4rem">Adding a New Song -</h1>
        <form class="flex formdata" action="#" method="POST">
            <div class="flex field">
                <label for="sname">Song Name </label>
                <input class="input" type="text" name="song_name" id="sname">
            </div>
            <div class="flex field">
                <label for="date">Date Released </label>
                <input  class="input" type="date" name="released_date" id="date">
            </div>
            <div class="flex field">
                <label for="photo">Artwork </label>
                <input class="input" type="file" name="artwork" id="photo" value="Upload Image">
            </div>
            <div class="flex field">
                <label for="aname">Artist </label>
                <input class="input" type="text" name="artists[]" list="aname">
                <datalist id="aname">
                <?php
                    $q1="SELECT artist_name from artist";
                    $res=mysqli_query($conn,$q1);
                    $row=mysqli_num_rows($res);
                    while($data=mysqli_fetch_assoc($res))
                    {
                        $artist_names=$data['artist_name'];
                        echo <<<a
                             <option value="$artist_names"></option>
                             a;                       
                    }
                ?>
                </datalist>
            </div>
            <div style="text-align: center; margin-top: 3rem;">
                <input class="button" type="button" value="Save">
                <input class="button" type="reset" value="cancel">
             </div>
        </form>
    </section>

    <section class="addartist flex">
        <div class="flex header">
            <h1>Add Artist -</h1>
            <button class="cross">&#9747</button>
        </div>
        <form class="flex artistdata" action="#" method="POST">
            <div class="flex field">
                <label for="AN">Artist Name </label>
                <input class="input" type="text" name="artist_name" id="AN">
            </div>
            <div class="flex field">
                <label for="DOB">Date of Birth </label>
                <input  class="input" type="date" name="DOB" id="DOB">
            </div>
            <div class="flex field">
                <label for="boi">Bio </label>
                <textarea class="input"  name="bio" id="bio" ></textarea>
            </div>
            <div style="text-align: center; margin-top: 3rem;">
                <input class="button" type="button" value="Save">
                <input class="button" type="reset" value="cancel">
             </div>
        </form>
    </section>
</body>
</html>