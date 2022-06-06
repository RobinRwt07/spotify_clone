<?php
$conn=mysqli_connect("localhost","root","Robin@123","spotify");
if(!$conn)
{
    die("unable to connect database".mysqli_connect_error());
}
?>