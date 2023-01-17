<?php
    require_once('config/connection.php');
    $chat_id = $_POST['chat_id'];
    $message = $_POST['message'];
    $sql = "INSERT INTO `messages` (`id`, `chat_id`, `message`) VALUES (NULL, '$chat_id', '$message');";
    $result=mysqli_query($connection, $sql);
    if ($result==false) {
        mysqli_error($connection);
    }
    
?>