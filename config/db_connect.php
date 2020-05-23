<?php
    //connect to db
    $conn= mysqli_connect('localhost', 'noxx', '0000', 'gidi_hotels');

    //check connection
    if (!$conn){
        echo 'connection error';
    }
?>