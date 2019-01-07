<?php
    $link = mysqli_connect("localhost", "root");
    if($link){
        echo "connected successfully <br>";
        echo "connection number = $link->thread_id";
    }
    else
    {
        die('Could not connect: ' . mysqli_error());
    }
    mysqli_close($link);
?>
