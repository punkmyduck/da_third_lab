<?php
require_once('config/connection.php');
$chat_name=$_POST['chat_name'];
$sql = "INSERT INTO `chats` (`id`, `name`) VALUES (NULL, '$chat_name');";
$result=mysqli_query($connection, $sql);
if ($result==false){
    mysqli_error($connection);
}

$sql = "SELECT *  FROM `chats` WHERE `name` LIKE '$chat_name';";
$result=mysqli_query($connection, $sql);
if ($result==false){
    mysqli_error($connection);
}
$row=mysqli_fetch_assoc($result);
echo $row['id'];
?>