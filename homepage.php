<?php
    $showerror=false;
    $showmsg=false;
    require './database_connection.php';
    if($_SERVER['REQUEST_METHOD']=="GET")
    {
        if(isset($_GET['artist_name']) && isset($_GET['DOB']) && isset($_GET['bio']))
        {
            if(empty($_GET['artist_name']) || empty($_GET['DOB']) || empty($_GET['bio']) )
            {
                $showerror="please fill the form.";
            }
            else
            {
            $A_name=$_GET['artist_name'];
            $DOB=$_GET['DOB'];
            $bio=$_GET['bio'];

            $q="SELECT * from artist WHERE artist_name='$A_name' AND date_of_birth='$DOB' AND bio='$bio' ";
            $result=mysqli_query($conn,$q);
            if(mysqli_num_rows($result)>0)
            {
                $showerror="artist already exist";
            }
            else
            {
                $query="INSERT INTO artist (artist_name,date_of_birth,bio) values ('$A_name','$DOB','$bio')";
                $res=mysqli_query($conn,$query);
                if($res)
                {
                    $showmsg="Artist data inserted successfully";
                }
                else
                {
                    $showerror="unable to insert record";
                }
            }
            }
        }
        // else
        // {
        //     $showerror="input field can not be empty";   
        // }
    }
    mysqli_close($conn);
    ?>


<!-- insert song data into database -->
<?php
  $path="./Artwork/";
  if(!file_exists($path))
  {
      mkdir($path);
  }
  $artworkpath="Artwork/";
  if($_SERVER['REQUEST_METHOD']=='POST')
  {
    if( isset($_POST['song_name']) && isset($_POST['released_date']) && isset($_POST['artists']) && isset($_FILES['artwork']))
    {
        $songName=$_POST['song_name'];
        $date=$_POST['released_date'];
        $artwork=$_FILES['artwork'];
        $artistName=$_POST['artists'];
        require 'database_connection.php';
        $q3="SELECT * FROM artist WHERE artist_name = '$artistName' ";
        $checkArtist=mysqli_query($conn,$q3);
        if(mysqli_num_rows($checkArtist)==0)
        {
            $showerror="please add artist.";
            mysqli_close($conn);
        }
        else
        {          
            $artworkName= $artworkpath.basename($_FILES['artwork']['name']);
            #checking if song already exist or not
            $quer1="SELECT * FROM songs WHERE song_name = '$songName' AND date_released='$date' AND singer= '$artistName' ";
            $result=mysqli_query($conn,$quer1);
            $rows=mysqli_num_rows($result);
            if($rows>0)
            {
                $showerror="Song Already Exist";
            }
            else
            {    
                $result1=move_uploaded_file($_FILES['artwork']['tmp_name'],$artworkName);
                if($result1)
                {
                    $query2="INSERT INTO songs (song_name,date_released,artwork,singer) VALUES(?,?,?,?)";
                    $stmt=mysqli_prepare($conn,$query2);
                    $success=mysqli_stmt_bind_param($stmt,"ssss",$songName,$date,$artworkName,$artistName);
                    if($success)
                    {
                    
                        $result3=mysqli_stmt_execute($stmt);
                        if($result3)
                        {
                            $showmsg="Successfully added.";
                        }
                        else
                        {
                            $showerror="Unable to add Book.";
                        }
                    }
                }
            }
        }
         
    }
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

    <!-- add new song section -->
    <section class="songcontainer"  id="addsongbox">

        <div class="addsongdetails flex">
            <div class="flex songheader">
                <h1 style="font-size:2.5rem;">Adding a New Song -</h1>
                <button class="cross" onclick="document.getElementById('addsongbox').style.display='none'">&#9747</button>
            </div>
            <form class="flex formdata" action="#" method="POST" enctype="multipart/form-data">
                <div class="flex field">
                    <label for="sname">Song Name </label>
                    <input class="input" type="text" name="song_name" id="sname" required>
                </div>
                <div class="flex field">
                    <label for="date">Date Released </label>
                    <input class="input" type="date" name="released_date" id="date" required>
                </div>
                <div class="flex field">
                    <label for="photo">Artwork </label>
                    <input class="input" type="file" name="artwork" id="photo" value="Upload Image" accept="image/*"
                        required>
                </div>
                <div class="flex field">
                    <label for="aname">Artist </label>
                    <input class="input" type="text" name="artists" list="aname" Placeholder="Search Artist" required>
                    <datalist id="aname">
                        <?php
                        require './database_connection.php';
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
                        mysqli_close($conn);
                        ?>
                    </datalist>
                </div>
                <div style="text-align: center; margin-top: 3rem;">
                    <input class="button" type="submit" value="Save">
                    <input class="button" type="reset" value="cancel">
                    <button class="button" onclick=" document.getElementById('addartistsection').style.display='block' ">+ Add Artist</button>
                </div>
            </form>
            </div>
    </section>

            <!-- display message -->
    <?php
        if($showmsg==TRUE)
        {
        echo  "<div class='alert_message'>
                    <p class='h2'>$showmsg</p>
                    <div class='cross1' onclick='this.parentNode.remove();'>&times;</div>
                </div>";
                $showmsg=false; 
        }    
        if($showerror==TRUE)
        {
        echo  "<div class='warning_message'>
                    <p class='h2'>$showerror</p>
                    <div class='cross1' onclick='this.parentNode.remove();'>&times;</div>
                </div>";
                $showesrror=false; 
        }      
    ?>

    <!-- top songs sections -->
    <section class="TopSongs flex">
        <div class="Songheading flex">
            <h1 style="font-size:3rem;">TOP 10 Songs</h1>
            <button class="button" onclick="document.getElementById('addsongbox').style.display='block'" >+ Add Song</button>
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


    <!-- top artist section -->
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

  
<!-- add artist section -->
    <section class="artistcontianer flex" id="addartistsection">
        
        <div class="addartist flex" >
            <div class="flex header">
                <h1>Add Artist -</h1>
                <button class="cross" onclick="document.getElementById('addartistsection').style.display='none'">&#9747 </button>
            </div>
            <form class="flex artistdata" action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="GET">
                <div class="flex field">
                    <label for="AN">Artist Name </label>
                    <input class="input" type="text" name="artist_name" id="AN">
                </div>
                <div class="flex field">
                    <label for="DOB">Date of Birth </label>
                    <input class="input" type="date" name="DOB" id="DOB">
                </div>
                <div class="flex field">
                    <label for="boi">Bio </label>
                    <textarea class="input" name="bio" id="bio"></textarea>
                </div>
                <div style="text-align: center; margin-top: 3rem;">
                    <input class="button" type="submit" value="Save">
                    <input class="button" type="reset" value="cancel">
                </div>
            </form>
        </div>
    </section>
</body>
</html>