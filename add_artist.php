<?php
    require './database_connection.php';
    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        if(isset($_POST['artist_name']) && isset($_POST['DOB']) && isset($_POST['bio']))
        {
            $A_name=$_POST['artist_name'];
            $DOB=$_POST['DOB'];
            $bio=$_POST['bio'];

            $q="SELECT * from artist WHERE artist_name='$A_name' AND date_of_birth='$DOB' AND bio='$bio' ";
            $result=mysqli_query($conn,$q);
            if(mysqli_num_rows($result)>0)
            {
                echo "artist already exist";
            }
            else
            {
                $query="INSERT INTO artist (artist_name,date_of_birth,bio) values ('$A_name','$DOB','$bio')";
                $res=mysqli_query($conn,$query);
                if($res)
                {
                    echo "Artist data inserted successfully";
                }
                else
                {
                    echo "unable to insert record";
                }
            }
        }
        else
        {
            echo "input field can not be empty";   
        }
    }
    mysqli_close($conn);
    ?>